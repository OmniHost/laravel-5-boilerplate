<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\RadiostationEntrants;

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;


class MailBlast extends Mailable
{
	use Queueable, SerializesModels;


	protected $station;
	protected $contest;
	protected $notification;
	protected $sparky;


    /**
     * Create a new message instance.
     *
     * @return void
     */
	public function __construct($notification)
    {
		//
		$this->notification = $notification;
		$this->contest = $this->notification->radiostationContest;
		$this->station = $this->contest->getStation();

		$httpClient = new GuzzleAdapter(new Client());
		$this->sparky = new SparkPost($httpClient, ['key'=> config('services.sparkpost.secret')]);
	}


	public function sendToSparkPost(){
	//	dd($this->doBuild());
		$promise = $this->sparky->transmissions->post($this->doBuild());
		return $promise->wait();

	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function getHtml()
    {
        return $this->view('mail.contest.mailblast')->with([
			'station' => $this->station->toArray()
		]);
	}

	public function build(){
		return $this->getHtml();
	}

	public function generateOptions(){

		//dd($this->notification->schedule->shiftTimezone($this->station->timezone)->setTimezone('UTC')->toAtomString());
		return [
			'start_time' => $this->notification->schedule ? $this->notification->schedule->shiftTimezone($this->station->timezone)->setTimezone('UTC')->toAtomString() : today()->toAtomString()
		];

	}

	public function doBuild() {
		$from = config('mail.from');
		$from['name'] = $this->station->name . ' - vai ' . $from['name'];

		return [
			'content' => [
				'from' => [
					'name' => $from['name'],
					'email' => $from['address'],
				],
				'subject' => $this->notification->subject,
				'html' => $this->getHtml()->render(),
			],
			'substitution_data' => ['name' => 'Name Here'],
			'recipients' => $this->getRecipients(),
			'options' => $this->generateOptions()
		];
	}


	public function getRecipients(){

		$suburb = $this->notification->suburb;
		$initials = $this->notification->initials;
		$entrants = RadiostationEntrants::where('completed',1)->where('radiostation_contests_id' , $this->notification->contest_id);
		if($suburb){
			$entrants->where('address1', $suburb);
		}
		if($initials){
			$entrants->where(\DB::raw('concat_ws(" ", LEFT(first_name,1), LEFT(last_name,1))'), $initials);
		}

		$recipients = [];

		foreach($entrants->get() as $entrant){
			$recipients[] = [
				'address' => [
					'name' => $entrant->first_name,
					'email' => $entrant->email,
				],
				'substitution_data' => [
					'link' => route('frontend.entrant.icouldbenext', $entrant->uuid)
				]
				];
		}

		return $recipients;
	}
}

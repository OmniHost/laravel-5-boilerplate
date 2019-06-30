<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\NexmoMessage;
use Abstractrs\UrlShortener\Facades\UrlShortener;

class ContestEntered extends Notification
{
    use Queueable;

	protected $entrant;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($entrant)
    {
		$this->entrant = $entrant;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toNexmo($notifiable)
    {

        return (new NexmoMessage)
		->content($this->genereateContent())
		->from($this->generateFrom());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
			//
			'content' => $this->genereateContent(),
			'from' => $this->generateFrom()
        ];
	}


	protected function genereateContent(){

		$entry_url = route('frontend.entryurl', [
			'stationSlug' => $this->entrant->station->slug,
			'contestSlug' => $this->entrant->contest->slug,
			'uuid' => $this->entrant->uuid
			]);
		//url('/entries/' . $this->entrant->station->slug . '/' . $this->entrant->uuid);
		$url = UrlShortener::driver('bitly')->shorten($entry_url);

		$message =  'Thank you for entering ' . $this->entrant->contest->name . ' through ' . $this->entrant->station->name;
		$message .= ' Please complete your entry at ' . $url . ' .';
		return $message;
	}

	protected function generateFrom(){
		return '15554443333';
	}
}

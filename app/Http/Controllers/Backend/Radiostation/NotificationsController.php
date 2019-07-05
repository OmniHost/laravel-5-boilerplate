<?php

namespace App\Http\Controllers\Backend\Radiostation;

use App\Http\Controllers\Controller;
use App\Models\Radiostation;
use App\Repositories\Backend\Radiostations\StationContestEntrantsRepository;
use App\Repositories\Backend\Radiostations\StationsRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Models\RadiostationNotifications;
use App\Models\Radiostation as RadiostationModel;
use App\Models\RadiostationContests;

use App\Mail\MailBlast;


class NotificationsController extends Controller
{



    /**
     * Insert a mailblast
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RadiostationContests $contest, Request $request)
    {
		$contest->hasAccess();

		$schedule = empty($request->post('sendtime')) ? today()->format("Y-m-d H:i:s") : \Carbon\Carbon::createFromFormat("Y-m-d h:i a", $request->post('sendtime'));

	//	dd($schedule);

		$record = [
			'contest_id' => $contest->id,
			'schedule' => $schedule,
			'is_sms' => '0',
			'initials' => $request->post('initials'),
			'suburb' => $request->post('suburb'),
			'subject' => 'Head’s up, we’ve narrowed it down.',
			'body' => ''
		];

		$notification = RadiostationNotifications::create($record);

		$mailer = new MailBlast($notification);
		$mail = $mailer->sendToSparkPost();

		return response()->json('success');


		//$notification->notify(new SendMailBlast($notification));



		//$notifications = RadiostationNotifications::where('contest_id', $contest->id)->orderBy('created_at', 'desc');

		//$entrants = $this->stationEntrantsRepository->where('radiostation_contests_id', $contest)->where('completed',1);


		/*
		return (new ContestProfileCompleted($entry))
		->toMail($entry);
		*/

    }


/*	public function processQueue(){
		$notification = RadiostationNotifications::find(1);
		$mailer = new MailBlast($notification);
		$mail = $mailer->sendToSparkPost();


		dd($mail);

		$contest = $notification->radiostationContest;
		$station = $contest->getStation();

		$promise = $sparky->transmissions->post();

	}*/



}

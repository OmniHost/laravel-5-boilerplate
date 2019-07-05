<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\NexmoMessage;
use Abstractrs\UrlShortener\Facades\UrlShortener;

use App\Mail\EntryProfileComplete;

class ContestProfileCompleted extends Notification implements ShouldQueue
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


		return (new EntryProfileComplete($this->entrant));
    }



}

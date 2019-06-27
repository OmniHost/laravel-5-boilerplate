<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\NexmoMessage;

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
			'from' => $this->generateFrom(),
			'entrant' => $this->entrant
        ];
	}


	protected function genereateContent(){
		return 'This is the SMS message';
	}

	protected function generateFrom(){
		return '15554443333';
	}
}

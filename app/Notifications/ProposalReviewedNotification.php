<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TalkProposal;

class ProposalReviewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $talkProposal;

    /**
     * Create a new notification instance.
     *
     * @param  TalkProposal  $talkProposal
     * @return void
     */
    public function __construct(TalkProposal $talkProposal)
    {
        $this->talkProposal = $talkProposal;
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
        return (new MailMessage)
                    ->subject('Your Talk Proposal Has Been Reviewed')
                    ->greeting("Hello, {$this->talkProposal->speaker->name}")
                    ->line("Your proposal titled \"{$this->talkProposal->title}\" has been reviewed.")
                    ->line("Current Status: " . ucfirst($this->talkProposal->status))
                    ->action('View Proposal', url("/talk-proposals/{$this->talkProposal->id}"))
                    ->line('Thank you for your submission to our event.');
    }
}

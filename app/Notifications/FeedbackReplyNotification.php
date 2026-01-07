<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackReplyNotification extends Notification
{
    use Queueable;

    protected $feedback;

    public function __construct(Contact $feedback)
    {
        $this->feedback = $feedback;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Tanggapan untuk Feedback Anda - Catering UMKM')
                    ->greeting('Halo ' . $this->feedback->name . '!')
                    ->line('Terima kasih atas feedback Anda dengan subjek: "' . $this->feedback->subject . '"')
                    ->line('Tanggapan kami: ' . $this->feedback->reply_message)
                    ->line('Feedback Anda sangat berharga untuk perbaikan layanan kami.')
                    ->salutation('Salam, Tim Catering UMKM');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Tanggapan Feedback',
            'message' => 'Admin telah menanggapi feedback Anda: "' . $this->feedback->subject . '"',
            'contact_id' => $this->feedback->id,
            'reply_message' => $this->feedback->reply_message,
            'type' => 'feedback_reply'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'contact_id' => $this->feedback->id,
            'subject' => $this->feedback->subject,
            'reply_message' => $this->feedback->reply_message
        ];
    }
}
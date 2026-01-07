<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ContactReplyNotification extends Notification
{
    use Queueable;

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Balasan untuk Pesan Anda - Catering UMKM')
                    ->greeting('Halo ' . $this->contact->name . '!')
                    ->line('Kami telah membalas pesan Anda dengan subjek: "' . $this->contact->subject . '"')
                    ->line('Balasan: ' . $this->contact->reply_message)
                    ->line('Terima kasih telah menghubungi kami!')
                    ->salutation('Salam, Tim Catering UMKM');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Balasan Pesan Kontak',
            'message' => 'Admin telah membalas pesan Anda dengan subjek "' . $this->contact->subject . '"',
            'contact_id' => $this->contact->id,
            'reply_message' => $this->contact->reply_message,
            'type' => 'contact_reply'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'contact_id' => $this->contact->id,
            'subject' => $this->contact->subject,
            'reply_message' => $this->contact->reply_message
        ];
    }
}
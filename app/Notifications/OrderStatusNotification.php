<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $oldStatus;
    protected $newStatus;

    public function __construct(Order $order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $statusMessages = [
            'payment_verified' => 'Pembayaran Anda telah diverifikasi',
            'preparing' => 'Pesanan Anda sedang dipersiapkan',
            'ready' => 'Pesanan Anda sudah siap',
            'on_delivery' => 'Pesanan Anda sedang dalam perjalanan',
            'delivered' => 'Pesanan Anda telah sampai',
            'completed' => 'Pesanan Anda telah selesai'
        ];

        return (new MailMessage)
                    ->subject('Update Status Pesanan #' . $this->order->order_number)
                    ->greeting('Halo ' . $this->order->user->name . '!')
                    ->line('Status pesanan Anda telah diperbarui.')
                    ->line('Nomor Pesanan: ' . $this->order->order_number)
                    ->line('Status: ' . ($statusMessages[$this->newStatus] ?? ucfirst($this->newStatus)))
                    ->action('Lihat Pesanan', route('user.orders.show', $this->order->id))
                    ->line('Terima kasih telah mempercayai layanan kami!')
                    ->salutation('Salam, Tim Catering UMKM');
    }

    public function toDatabase($notifiable)
    {
        $statusMessages = [
            'payment_verified' => 'Pembayaran diverifikasi',
            'preparing' => 'Sedang dipersiapkan',
            'ready' => 'Siap untuk dikirim',
            'on_delivery' => 'Dalam perjalanan',
            'delivered' => 'Telah sampai',
            'completed' => 'Selesai'
        ];

        return [
            'title' => 'Update Status Pesanan',
            'message' => 'Pesanan #' . $this->order->order_number . ' - ' . ($statusMessages[$this->newStatus] ?? ucfirst($this->newStatus)),
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'type' => 'order_status'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus
        ];
    }
}
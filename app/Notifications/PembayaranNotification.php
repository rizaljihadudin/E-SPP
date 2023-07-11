<?php

namespace App\Notifications;

use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PembayaranNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $pembayaran;
    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', WhacenterChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

    /** mengirim ke notifikasi wali di web */
    public function toArray(object $notifiable): array
    {
        return [
            'tagihan_id'    => $this->pembayaran->transaksi_id,
            'wali_id'       => $this->pembayaran->wali_id,
            'pembayaran_id' => $this->pembayaran->id,
            'title'         => "Pembayaran Tagihan",
            'message'       => "<b>{$this->pembayaran->wali->name}</b> Melakukan pembayaran tagihan. ",
            'url'           => route('pembayaran.show', $this->pembayaran->id)
        ];
    }

    /** pengiriman notifikasi ke Whatsapp */
    public function toWhacenter($notifiable)
    {
        /** membuat link login operator */
        $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(30),
            [
                'pembayaran_id' => $this->pembayaran->id,
                'user_id'       => $notifiable->id,
                'url'           => route('pembayaran.show', $this->pembayaran->id)
            ]
        );
        return (new WhacenterService())
            ->to($notifiable->no_hp)
            ->line("Hallo Operator,")
            ->line("Ada Pembayaran Tagihan SPP")
            ->line("{$this->pembayaran->wali->name} Melakukan pembayaran tagihan.")
            ->line("Untuk melihat info pembayaran, klik link berikut: {$url}")
            ->line("JANGAN BERIKAN LINK INI KEPADA SIAPAPUN.");
    }
}

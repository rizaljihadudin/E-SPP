<?php

namespace App\Notifications;

use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PembayaranKonfirmasiNotification extends Notification
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
    public function toArray(object $notifiable): array
    {
        return [
            'pembayaran_id'     => $this->pembayaran->id,
            'title'             => 'Konfirmasi Pembayaran',
            'messages'          => 'Pembayaran Tagihan SPP atas nama ' . $this->pembayaran->transaksi->siswa->nama . ' telah di konfirmasi.',
            'url'               => route('wali.pembayaran.show', $this->pembayaran->id)
        ];
    }

    /** pengiriman notifikasi ke Whatsapp Wali Murid */
    public function toWhacenter($notifiable)
    {
        /** membuat link login operator */
        $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(30),
            [
                'pembayaran_id' => $this->pembayaran->id,
                'user_id'       => $notifiable->id,
                'url'           => route('wali.tagihan.index')
            ]
        );
        return (new WhacenterService())
            ->to($notifiable->no_hp)
            ->line("Hallo {$notifiable->name},")
            ->line("Pembayaran Tagihan siswa atas nama : {$this->pembayaran->transaksi->siswa->nama} Sudah Di konfimasi")
            ->line("Untuk melihat info pembayaran, klik link berikut: {$url}")
            ->line("JANGAN BERIKAN LINK INI KEPADA SIAPAPUN.");
    }
}

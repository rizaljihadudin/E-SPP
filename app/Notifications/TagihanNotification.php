<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TagihanNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $transaksi;
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
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
            'tagihan_id'    => $this->transaksi->id,
            'title'         => "Tagihan SPP Bulan " . $this->transaksi->siswa->nama,
            'messages'      => "Tagihan SPP Bulan " . $this->transaksi->tanggal_tagihan->translatedFormat('F Y'),
            'url'           => route('wali.tagihan.show', $this->transaksi->id)
        ];
    }

    /** pengiriman notifikasi ke Whatsapp Operator */
    public function toWhacenter($notifiable)
    {
        /** membuat link login operator */
        $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(30),
            [
                'tagihan_id'    => $this->transaksi->id,
                'user_id'       => $notifiable->id,
                'url'           => route('wali.tagihan.show', $this->transaksi->id)
            ]
        );

        $bulanTagihan = $this->transaksi->tanggal_tagihan->translatedFormat('F Y');

        return (new WhacenterService())
            ->to($notifiable->no_hp)
            ->line("Assalamualaikum, {$this->transaksi->siswa->wali->name}")
            ->line("Berikut kami kirim informasi tagihan SPP untuk bulan {$bulanTagihan} atas nama {$this->transaksi->siswa->nama}")
            ->line("Jika sudah melakukan pembayaran, silahkan klik link berikut {$url}.")
            ->line("Link ini berlaku selama 10 hari.")
            ->line("JANGAN BERIKAN LINK INI KEPADA SIAPAPUN.")
            ->file("https://i.ibb.co/S5GYRNL/bird-thumbnail.jpg");
    }
}

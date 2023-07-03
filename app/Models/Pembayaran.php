<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaksi_id',
        'wali_id',
        'tanggal_bayar',
        'status_konfirmasi',
        'jumlah_dibayar',
        'bukti_bayar',
        'metode_pembayaran',
        'user_id'
    ];

    protected $with = ['user', 'transaksi'];


    protected $casts = [
        'tanggal_bayar' => 'date'
    ];

    protected static function booted(): void
    {
        /** to insert user_id after create data on table biayas */
        static::creating(function (Pembayaran $pembayaran) {
            $pembayaran->user_id = auth()->user()->id;
        });

        /** to insert user_id after update on table biayas */
        static::updating(function (Pembayaran $pembayaran) {
            $pembayaran->user_id = auth()->user()->id;
        });
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

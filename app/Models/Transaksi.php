<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'angkatan',
        'kelas',
        'tanggal_tagihan',
        'tanggal_jatuh_tempo',
        'nama_biaya',
        'jumlah_biaya',
        'keterangan',
        'denda',
        'status',
        'user_id'
    ];

    protected $visible = ['id'];

    protected $casts = [
        'tanggal_tagihan'       => 'date',
        'tanggal_jatuh_tempo'   => 'date'
    ];

    protected $with = ['user', 'siswa', 'transaksiDetails'];

    protected static function booted(): void
    {
        /** to insert user_id after create data on table biayas */
        static::creating(function (Transaksi $transaksi) {
            $transaksi->user_id = auth()->user()->id;
        });

        /** to insert user_id after update on table biayas */
        static::updating(function (Transaksi $transaksi) {
            $transaksi->user_id = auth()->user()->id;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function transaksiDetails(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}

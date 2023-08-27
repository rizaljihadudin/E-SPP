<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Pembayaran extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'siswas.nama' => 10,
            'siswas.nisn' => 10,
        ],
        'joins' => [
            'transaksis' => ['transaksis.id', 'pembayarans.transaksi_id'],
            'siswas' => ['siswas.id','transaksis.siswa_id']
        ],
    ];

    protected $fillable = [
        'transaksi_id',
        'wali_id',
        'bank_wali_id',
        'bank_sekolah_id',
        'tanggal_bayar',
        'tanggal_konfirmasi',
        'jumlah_dibayar',
        'bukti_bayar',
        'metode_pembayaran',
        'user_id'
    ];

    protected $with = ['user', 'transaksi', 'bankSekolah'];
    protected $append = ['status_konfirmasi'];


    protected $casts = [
        'tanggal_bayar'         => 'date',
        'tanggal_konfirmasi'    => 'datetime'
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

    protected function statusKonfirmasi(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->tanggal_konfirmasi) ? 'Sudah Dikonfirmasi' : 'Belum Dikonfirmasi'
        );
    }


    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    public function waliBank(): BelongsTo
    {
        return $this->belongsTo(WaliBank::class, 'bank_wali_id');
    }

    public function bankSekolah(): BelongsTo
    {
        return $this->belongsTo(BankSekolah::class, 'bank_sekolah_id');
    }
}

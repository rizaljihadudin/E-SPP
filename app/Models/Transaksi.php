<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Nicolaslopezj\Searchable\SearchableTrait;

class Transaksi extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'siswas.nama' => 10,
            'siswas.nisn' => 10,
        ],
        'joins' => [
            'siswas' => ['siswas.id','transaksis.siswa_id'],
        ],
    ];

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
        'tanggal_jatuh_tempo'   => 'date',
        'tanggal_lunas'         => 'date'
    ];

    protected $with     = ['user', 'siswa', 'transaksiDetails'];
    protected $append   = ['total_tagihan', 'total_pembayaran'];

    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->transaksiDetails->sum('jumlah_biaya'),
        );
    }

    protected function totalPembayaran(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->pembayaran->sum('jumlah_dibayar'),
        );
    }

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

    public function updateStatus()
    {
        if($this->total_pembayaran >= $this->total_tagihan){
            $tanggalBayar = $this->pembayaran()
                ->orderBy('tanggal_bayar', 'desc')
                ->first()
                ->tanggal_bayar;
            $this->update([
                'status'        => 'lunas',
                'tanggal_lunas' => $tanggalBayar
            ]);
        }

        if($this->total_pembayaran > 0 && $this->total_pembayaran < $this->total_tagihan){
            $this->update([
                'status'        => 'angsuran',
                'tanggal_lunas' => null
            ]);
        }

        if($this->total_pembayaran <= 0){
            $this->update([
                'status'        => 'baru',
                'tanggal_lunas' => null
            ]);
        }
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

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getStatusTransaksiWali()
    {
        if ($this->status == 'baru') {
            return 'Belum dibayar';
        }

        if ($this->status == 'lunas') {
            return 'Sudah dibayar';
        }

        return $this->status;
    }

    public function scopeWaliSiswa($query)
    {
        return $query->whereIn('siswa_id', Auth::user()->getAllSiswaId());
    }
}

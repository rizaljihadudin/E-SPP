<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStatus\HasStatuses;

class Siswa extends Model
{
    use HasFactory;
    use HasStatuses;

    protected $fillable = [
        'nama',
        'wali_id',
        'biaya_id',
        'wali_status',
        'nisn',
        'foto',
        'jurusan_id',
        'kelas',
        'angkatan',
        'user_id',
        'created_at'
    ];


    protected $with = ['jurusan'];

    /** untuk relasi user_id : yang input data */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** untuk relasi wali_id : wali dari si murid */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id')->withDefault([
            'nama_jurusan' => '-'
        ]);
    }

    public function biaya(): BelongsTo
    {
        return $this->belongsTo(Biaya::class, 'biaya_id');
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id');
    }

    protected static function booted(): void
    {
        /** to insert user_id after create data on table biayas */
        static::creating(function (Siswa $siswa) {
            $siswa->user_id = auth()->user()->id;
        });

        static::created(function (Siswa $siswa) {
            $siswa->setStatus('aktif');
        });

        /** to insert user_id after update on table biayas */
        static::updating(function (Siswa $siswa) {
            $siswa->user_id = auth()->user()->id;
        });
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('nama', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }
}

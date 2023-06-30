<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;
    protected $guarder = [];

    protected $fillable = [
        'nama',
        'wali_id',
        'wali_status',
        'nisn',
        'foto',
        'jurusan_id',
        'kelas',
        'angkatan',
        'user_id',
        'created_at'
    ];


    /** untuk relasi user_id : yang input data */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** untuk relasi wali_id : wali dari si murid */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id')->withDefault([
            'name' => 'Belum ada wali'
        ]);
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id')->withDefault([
            'nama_jurusan' => '-'
        ]);
    }
}

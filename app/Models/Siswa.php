<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;
    protected $guarder = [];


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
}

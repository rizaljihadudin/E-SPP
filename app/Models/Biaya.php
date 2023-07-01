<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biaya extends Model
{
    use HasFactory;

    protected $guarder = [];

    protected $fillable = [
        'nama_biaya',
        'jumlah',
        'user_id'
    ];

    protected static function booted(): void
    {
        /** to insert user_id after create data on table biayas */
        static::creating(function (Biaya $biaya) {
            $biaya->user_id = auth()->user()->id;
        });

        /** to insert user_id after update on table biayas */
        static::updating(function (Biaya $biaya) {
            $biaya->user_id = auth()->user()->id;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('nama_biaya', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }
}

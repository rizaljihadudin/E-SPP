<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Biaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_biaya',
        'jumlah',
        'user_id',
        'parent_id'
    ];

    protected $append = ['nama_biaya_full', 'total_tagihan'];


    protected function namaBiayaFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($this->nama_biaya . ' - ' . formatRupiah($this->jumlah)),
            #set: fn ($value) => strtolower($value), 
        );
    }

    protected function totalTagihan(): Attribute
    {
        //dd($this->nama_biaya);
        return Attribute::make(
            get: fn ($value) => $this->children()->sum('jumlah'),
        );
    }

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

    public function children(): HasMany
    {
        return $this->hasMany(Biaya::class, 'parent_id', 'id');
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

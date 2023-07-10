<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaliBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'wali_id',
        'bank_id',
        'nomor_rekening',
        'nama_rekening'
    ];

    protected $append = ['nama_bank_full'];

    protected function namaBankFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->bank->nama_bank . ' - An. ' . ucwords($this->nama_rekening) . ' (' . $this->nomor_rekening . ')',
            #set: fn ($value) => strtolower($value), 
        );
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }
}

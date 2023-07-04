<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankSekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'nama_rekening',
        'nomor_rekening'
    ];


    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}

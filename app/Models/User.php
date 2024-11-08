<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'akses',
        'no_hp',
        'nohp_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeWali($q)
    {
        return $q->where('akses', 'wali');
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'wali_id', 'id');
    }

    public function getAllSiswaId(): array
    {
        return $this->siswa->pluck('id')->toArray();
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('name', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }
}

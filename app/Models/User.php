<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'email',
        'username',
        'password',
        'lastSignAt',
        'roles',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'lastSignAt' => 'datetime',
        'status' => 'integer',
        'roles' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id = (string)Str::uuid();
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}

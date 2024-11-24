<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comment extends Model
{
    protected $keyType = 'string';
    public $incrementing = false; 

    protected $fillable = [
        'user_id',
        'title_mal_id',
        'description',
        'likes',
        'dislikes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->id = (string)Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

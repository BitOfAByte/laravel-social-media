<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];



    public function user() {
        return $this->belongsTo(User::class);
    }

    public function updoots()
    {
        return $this->hasMany(Updoot::class);
    }

    public function userVote()
    {
        return $this->hasOne(Updoot::class)->where('user_id', auth()->id());
    }
}

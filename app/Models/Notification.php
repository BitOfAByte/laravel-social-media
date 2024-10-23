<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'sent_at'];

    public function userNotifications()
    {
        return $this->belongsTo(UserNotification::class);
    }
}

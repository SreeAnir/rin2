<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;
    protected $table ="notification_users";
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     
    public function scopeUnread($query)
    { 
        return $query->where('read_at', null );
    }
     
    
    
}

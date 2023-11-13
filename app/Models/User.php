<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Notification;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];
    
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
    
    /**
     * all notifications for the user.
     */
    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    
    /**
     * unread notifications for the user.
     */
    // public function unreadNotifications()
    // {
    //     return $this->notifications();
    // }
    // public function notifications()
    // {
    //     return $this->belongsToMany(Notification::class);
    // }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_users')
            ->withPivot('read_at')
            ->withTimestamps();
    }
    public function unreadNotifications()
    {
        return $this->notifications()
            ->whereHas('notificationUsers', function ($query) {
                $query->whereNull('read_at');
            });
    }
    
    public function scopeUsers($query)
    { 
        return $query->where('role',  self::ROLE_USER);
    }
    
    
}

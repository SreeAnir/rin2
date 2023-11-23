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
        'phone_number',
        'notification_switch',
        'role',
        'email_verified_at'
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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($user) {
    //         $user->phone_number = static::cleanPhoneNumber($user->phone_number);
    //     });
        
    // }
    protected static function cleanPhoneNumber($phoneNumber)
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }

    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = static::cleanPhoneNumber($value);
    }
    
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

<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
 
    use HasFactory;
    const TP_MARKET = 1;
    const TP_INVOICE = 2;
    const TP_SYSTEM = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notification_type',
        'note',
    ];

    public static function getTypeList()
    {
        return [
            self::TP_MARKET => 'Market',
            self::TP_INVOICE => 'Invoice',
            self::TP_SYSTEM => 'System',
        ];
    }
    
    // created_at_format
    public function getCreatedAtFormatAttribute()
    {
        return $this->created_at?->format('d/m/Y H:i:s');
    }

    public static function notificationTypeLabel($type)
    {
        $typeList = self::getTypeList();

        return isset($typeList[$type]) ? $typeList[$type] : null;
    }
  
 
    public function notificationUsers()
    {
        return $this->hasMany(NotificationUser::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_users')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}

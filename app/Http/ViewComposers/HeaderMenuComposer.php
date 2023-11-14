<?php 
// app/Http/ViewComposers/HeaderMenuComposer.php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Notification;
class HeaderMenuComposer
{
    public function compose(View $view)
    {
        $notification_count = Notification::whereHas('users', function ($query) {
            $query->where('read_at',null )->where(function ($query) {
                $query->whereNull('expire_on')
                    ->orWhere('expire_on', '>', now()); // Assuming 'expire_on' is a timestamp
            });
        })->count();
        $view->with('notification_count', $notification_count);
    }
}

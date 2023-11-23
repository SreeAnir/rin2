<?php
namespace App\Observers;

use App\Models\User;

class EmailChangeObserver
{
    public function updating(User $user)
    { 
        if ($user->isDirty('email')) {  
            $user->email_verified_at = null;
        }
    }
}

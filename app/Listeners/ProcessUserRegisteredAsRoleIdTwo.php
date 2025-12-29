<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegisteredAsRoleIdTwo;
use App\Models\Accountant;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessUserRegisteredAsRoleIdTwo implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param UserRegisteredAsRoleIdTwo $event
     * @return void
     */
    public function handle(object $event): void
    {
        //
        $user = $event->user;

        if ($user->role_id === 2) {
            Accountant::create([
                'user_id' => $user->id,
            ]);
        }
    }
}

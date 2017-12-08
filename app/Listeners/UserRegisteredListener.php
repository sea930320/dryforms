<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Laravel\Passport\ClientRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredListener
{
    /**
     * UserRegisteredListener constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param UserRegistered $event
     */
    public function handle(UserRegistered $event)
    {

    }
}

<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Laravel\Passport\ClientRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredListener
{
    const REDIRECT = '/callback';

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * UserRegisteredListener constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param UserRegistered $event
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->getUser();
        $this->clientRepository->create(
            $user->id, $user->name, static::REDIRECT
        );
    }
}

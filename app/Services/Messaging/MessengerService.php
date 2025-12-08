<?php

namespace App\Services\Messaging;


interface MessengerService
{
    public function send(string $address, string $message);
}

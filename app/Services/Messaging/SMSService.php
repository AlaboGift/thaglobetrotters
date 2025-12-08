<?php

namespace App\Services\Messaging;

use Exception;
use Illuminate\Support\Facades\Log;

class SMSService implements MessengerService
{
    private string $sender;

    public function __construct()
    {
        $this->sender = "";
    }

    public function send(string $address, string $message)
    {
        try {
        } catch (\Exception $e) {
            Log::error("SMS to : " . $address . " failed : " . $e->getMessage());
        }
    }
}

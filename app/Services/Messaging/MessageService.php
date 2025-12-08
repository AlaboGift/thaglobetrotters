<?php

namespace App\Services\Messaging;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MessageService
{
    public function sendMessage(string $service, string $address, string $message)
    {
        $messageService = Str::studly($service . '_service');
        $messageServiceClass = "App\Services\Messaging\\$messageService";

        if (class_exists($messageServiceClass)) {
            try {
                return app()->make($messageServiceClass)->send($address, $message);
            } catch (BindingResolutionException $e) {
                Log::info('Error sending message: ' . $e);
            }
        } else {
            return "Yeah.";
        }
    }
}


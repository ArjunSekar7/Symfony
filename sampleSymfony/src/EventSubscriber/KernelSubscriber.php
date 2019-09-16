<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['showMessage', 20],
                ['processMessage', 10],
            ]
            ];
    }

    public function showMessage()
    {
        echo 'Hello i am Subscriber   ';
    }

    public function processMessage()
    {
        echo 'Hello i am Subscriber processing the exception  ';
    }
}
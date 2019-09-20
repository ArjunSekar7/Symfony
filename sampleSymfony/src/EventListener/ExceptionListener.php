<?php

namespace App\EventListener;

class ExceptionListener
{
    public function onKernelException()
    {
        die("I am a Listener");
    }
}

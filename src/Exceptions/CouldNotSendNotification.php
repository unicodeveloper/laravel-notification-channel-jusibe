<?php

namespace NotificationChannels\Jusibe\Exceptions;

use Exception;
use DomainException;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(DomainException $exception)
    {
        return new static(
            "Service responded with an error '{$exception->getCode()}: {$exception->getMessage()}'");
    }
}

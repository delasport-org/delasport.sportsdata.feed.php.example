<?php

declare(strict_types=1);

namespace App\Kafka\MessageHandler;

use App\Kafka\Message\Event\EventMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EventHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
    ) { }

    public function __invoke(EventMessage $message): void
    {
        //TODO implement logic
        var_dump($message);
    }
}

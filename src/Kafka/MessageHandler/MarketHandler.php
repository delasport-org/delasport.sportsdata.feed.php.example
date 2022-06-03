<?php

declare(strict_types=1);

namespace App\Kafka\MessageHandler;

use App\Kafka\Message\Market\MarketMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MarketHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
    ) { }

    public function __invoke(MarketMessage $message): void
    {
        //TODO implement logic
        var_dump($message);
    }
}

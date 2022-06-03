<?php

declare(strict_types=1);

namespace App\Kafka\MessageHandler;

use App\Kafka\Message\Settlement\ResultSettlementMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ResultSettlementHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
    ) { }

    public function __invoke(ResultSettlementMessage $message): void
    {
        //TODO implement logic
        var_dump($message);
    }
}

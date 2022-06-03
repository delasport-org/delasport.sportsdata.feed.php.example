<?php

namespace App\Kafka\Serializer;

use App\Kafka\Message\AsyncMessageInterface;
use App\Kafka\Message\Market\MarketMessage;

class MarketSerializer extends AbstractSerializer
{
    protected function createMessageFromData(array $data): AsyncMessageInterface
    {
        return MarketMessage::createFromArray($data);
    }

    protected function getContentFromMessage(AsyncMessageInterface $message): AsyncMessageInterface
    {
        return $message;
    }
}

<?php

namespace App\Kafka\Serializer;

use App\Kafka\Message\AsyncMessageInterface;
use App\Kafka\Message\Event\EventMessage;

class EventSerializer extends AbstractSerializer
{
    protected function createMessageFromData(array $data): AsyncMessageInterface
    {
        return EventMessage::createFromArray($data);
    }

    protected function getContentFromMessage(AsyncMessageInterface $message): AsyncMessageInterface
    {
        return $message;
    }
}

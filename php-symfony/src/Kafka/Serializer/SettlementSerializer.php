<?php

namespace App\Kafka\Serializer;

use App\Kafka\Message\AsyncMessageInterface;
use App\Kafka\Message\Settlement\ResultSettlementMessage;

class SettlementSerializer extends AbstractSerializer
{
    protected function createMessageFromData(array $data): AsyncMessageInterface
    {
        return ResultSettlementMessage::createFromArray($data);
    }

    protected function getContentFromMessage(AsyncMessageInterface $message): AsyncMessageInterface
    {
        return $message;
    }
}

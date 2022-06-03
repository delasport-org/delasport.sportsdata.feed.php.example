<?php

declare(strict_types=1);

namespace App\Kafka\Serializer;

use Enqueue\RdKafka\RdKafkaMessage;
use Enqueue\RdKafka\Serializer;


class JsonSerializer implements Serializer
{
    public function toString(RdKafkaMessage $message): string
    {
        if (!$this->isJson($message->getBody())) {
            $json = json_encode($message->getBody());

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new \InvalidArgumentException(sprintf(
                    'The malformed json given. Error %s and message %s',
                    json_last_error(),
                    json_last_error_msg()
                ));
            }

            return $json;
        }

        return $message->getBody();
    }

    public function toMessage(string $string): RdKafkaMessage
    {
        return new RdKafkaMessage($string);
    }

    private function isJson($rawJson): bool
    {
        return !((json_decode($rawJson, true) === null));
    }
}

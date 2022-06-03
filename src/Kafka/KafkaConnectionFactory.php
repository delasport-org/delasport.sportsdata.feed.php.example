<?php

declare(strict_types=1);

namespace App\Kafka;

use App\Kafka\Serializer\JsonSerializer;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Interop\Queue\Context;

class KafkaConnectionFactory extends RdKafkaConnectionFactory
{
    public function createContext(): Context
    {
        $context = parent::createContext();
        $context->setSerializer(new JsonSerializer());

        return $context;
    }
}
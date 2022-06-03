<?php

declare(strict_types=1);

namespace App\Kafka;

use Enqueue\ConnectionFactoryFactoryInterface;
use Interop\Queue\ConnectionFactory;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class RdKafkaConnectionFactory implements ConnectionFactoryFactoryInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * https://docs.confluent.io/5.5.0/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cbaa2e905024b42d56f177547ef2c6921f2.
     */
    private const ERROR_CODE_BROKER_TRANSPORT_FAILURE = -195;

    public function __construct(
    ) { }

    public function create($config): ConnectionFactory
    {
        $config['error_cb'] = function ($kafka, int $errorCode, string $errorMsg): void {
            $context = ['fingerprint' => ['kafka', $errorCode]];

            if (self::ERROR_CODE_BROKER_TRANSPORT_FAILURE === $errorCode) {
                $this->logger->warning($errorMsg, $context);

                return;
            }

            $this->logger->error($errorMsg, $context);
        };

        return new KafkaConnectionFactory($config);
    }
}

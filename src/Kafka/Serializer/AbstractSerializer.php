<?php

declare(strict_types=1);

namespace App\Kafka\Serializer;

use App\Exception\SerializerErrorException;
use App\Kafka\Message\AsyncMessageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

abstract class AbstractSerializer implements SerializerInterface
{
    abstract protected function createMessageFromData(array $data): AsyncMessageInterface;
    abstract protected function getContentFromMessage(AsyncMessageInterface $message);

    public function __construct(protected LoggerInterface $logger) {}

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = substr($encodedEnvelope['body'], strpos($encodedEnvelope['body'], '{'));
        $headers = $encodedEnvelope['headers'];
        $data = json_decode($body, true);

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        $message = $this->createMessageFromData($data);

        // in case of redelivery, unserializable any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        return new Envelope($message, $stamps);
    }

    /**
     * @throws \RuntimeException
     */
    public function encode(Envelope $envelope): array
    {
        /** @var AsyncMessageInterface $message */
        $message = $envelope->getMessage();

        try {
            $data = $this->getContentFromMessage($message);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw new SerializerErrorException();
        }

        $allStamps = [];

        foreach ($envelope->all() as $stamps) {
            $allStamps[] = $stamps;
        }

        $allStamps = array_merge(...$allStamps);

        return [
            'body' => json_encode($data),
            'headers' => [
                'stamps' => serialize($allStamps)
            ],
        ];
    }
}

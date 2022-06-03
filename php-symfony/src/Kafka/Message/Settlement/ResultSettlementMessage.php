<?php

declare(strict_types=1);

namespace App\Kafka\Message\Settlement;

use App\Kafka\Message\AsyncMessageInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ResultSettlementMessage implements AsyncMessageInterface, \JsonSerializable
{
    protected ArrayCollection $markets;

    public function __construct(
        protected string $eventId,
        protected int $timestamp
    ) {
        $this->markets = new ArrayCollection();
    }

    public function addMarket(Market $market): void
    {
        $this->markets->add($market);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        $result = [
            'eventId' => $this->eventId,
            'timestamp' => $this->timestamp
        ];

        if (!empty($this->markets)) {
            $result['markets'] = $this->markets->toArray();
        }

        return $result;
    }

    public static function createFromArray(array $data): self
    {
        $message = new self(
            $data['eventId'],
            $data['timestamp'] ?? time()
        );

        foreach ($data['markets'] as $marketData) {
            $market = new Market(
                $marketData['id'],
                $marketData['marketTypeId'],
                $marketData['gamePeriodId'],
                $marketData['lineEntityId'],
            );

            foreach ($marketData['odds'] as $oddData) {
                $market->addOdd(
                    new Odd(
                        $oddData['id'],
                        $oddData['selectionStatus'])
                );
            }

            $message->addMarket($market);
        }

        return $message;
    }

    public function getContent(): array
    {
        return $this->toArray();
    }
}

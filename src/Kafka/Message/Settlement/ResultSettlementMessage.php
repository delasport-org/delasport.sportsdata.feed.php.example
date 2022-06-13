<?php

declare(strict_types=1);

namespace App\Kafka\Message\Settlement;

use App\Kafka\Message\AsyncMessageInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ResultSettlementMessage implements AsyncMessageInterface, \JsonSerializable
{
    protected ArrayCollection $odds;

    public function __construct(
        protected string $id,
        protected string $eventId,
        protected string $marketTypeId,
        protected string $sportId,
        protected string $leagueId,
        protected string $foreignKey,
        protected int $timestamp
    ) {
        $this->odds = new ArrayCollection();
    }

    public function addOdd(Odd $odd): void
    {
        $this->odds->add($odd);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'eventId' => $this->eventId,
            'marketTypeId' => $this->marketTypeId,
            'sportId' => $this->sportId,
            'leagueId' => $this->leagueId,
            'foreignKey' => $this->foreignKey,
            'odds' => $this->odds->toArray(),
            'timestamp' => $this->timestamp
        ];
    }

    public static function createFromArray(array $data): self
    {
        $message = new self(
            $data['id'],
            $data['eventId'],
            $data['marketTypeId'],
            $data['sportId'],
            $data['leagueId'],
            $data['foreignKey'],
            $data['timestamp'] ?? time()
        );

        foreach ($data['odds'] as $oddData) {
            $message->addOdd(
                new Odd(
                    $oddData['id'],
                    $oddData['selectionStatus'])
            );
        }

        return $message;
    }

    public function getContent(): array
    {
        return $this->toArray();
    }
}

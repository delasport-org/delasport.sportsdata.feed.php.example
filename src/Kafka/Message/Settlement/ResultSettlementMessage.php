<?php

declare(strict_types=1);

namespace App\Kafka\Message\Settlement;

use App\Kafka\Message\AsyncMessageInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ResultSettlementMessage implements AsyncMessageInterface, \JsonSerializable
{

    public function __construct(
        protected string $id,
        protected string $selectionStatus,
        protected string $oddId,
        protected string $marketId,
        protected string $eventId,
        protected string $marketTypeId,
        protected string $sportId,
        protected string $leagueId,
        protected string $foreignKey,
        protected int $timestamp
    ) { }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'selectionStatus' => $this->selectionStatus,
            'oddId' => $this->oddId,
            'marketId' => $this->marketId,
            'eventId' => $this->eventId,
            'marketTypeId' => $this->marketTypeId,
            'sportId' => $this->sportId,
            'leagueId' => $this->leagueId,
            'foreignKey' => $this->foreignKey,
            'timestamp' => $this->timestamp
        ];
    }

    public static function createFromArray(array $data): self
    {
        $message = new self(
            $data['id'],
            $data['selectionStatus'],
            (string)$data['oddId'],
            (string)$data['marketId'],
            (string)$data['eventId'],
            (string)$data['marketTypeId'],
            (string)$data['sportId'],
            (string)$data['leagueId'],
            (string)$data['foreignKey'],
            $data['timestamp'] ?? time()
        );

        return $message;
    }

    public function getContent(): array
    {
        return $this->toArray();
    }
}

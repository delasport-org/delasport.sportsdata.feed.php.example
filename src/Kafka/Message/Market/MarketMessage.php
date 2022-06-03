<?php

declare(strict_types=1);

namespace App\Kafka\Message\Market;

use Doctrine\Common\Collections\ArrayCollection;
use App\Kafka\Message\AsyncMessageInterface;

class MarketMessage implements AsyncMessageInterface, \JsonSerializable
{
    protected ArrayCollection $odds;

    public function __construct(
        protected string $id,
        protected string $eventId,
        protected ?string $invalidatedAt = null,
        protected ?string $marketTypeId = null,
        protected ?string $gamePeriodId = null,
        protected ?string $lineEntityId = null,
        protected ?string $marketKey = null,
        protected ?float  $spread = null,
        protected ?int $index = null,
        protected ?int $isHidden = null,
        protected ?int $isSuspended = null,
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
            'invalidatedAt' => $this->invalidatedAt,
            'marketTypeId' => $this->marketTypeId,
            'gamePeriodId' => $this->gamePeriodId,
            'lineEntityId' => $this->lineEntityId,
            'marketKey' => $this->marketKey,
            'spread' => $this->spread,
            'index' => $this->index,
            'isHidden' => $this->isHidden,
            'isSuspended' => $this->isSuspended,
            'odds' => $this->odds->toArray(),
        ];
    }

    public static function createFromArray(array $data): self
    {
        $message = new self(
            $data['id'],
            $data['eventId'],
            $data['invalidatedAt'] ?? null,
            $data['marketTypeId'] ?? null,
            $data['gamePeriodId'] ?? null,
            $data['lineEntityId'] ?? null,
            $data['marketKey'] ?? null,
            $data['spread'] ?? null,
            $data['index'] ?? null,
            $data['isHidden'] ?? null,
            $data['isSuspended'] ?? null,
        );

        foreach ($data['odds'] as $odd) {
            $message->addOdd(new Odd(
                $odd['id'],
                $odd['key'],
                $odd['value']
            ));
        }

        return $message;
    }

    public function getContent(): array
    {
        return $this->toArray();
    }
}

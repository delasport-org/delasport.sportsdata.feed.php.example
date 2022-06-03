<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

final class LiveScore implements \JsonSerializable
{
    public function __construct(
        protected string $lineEntityId,
        protected string $lineEntityName,
        protected string $gamePeriodId,
        protected string $gamePeriodName,
        protected int $homeTeam,
        protected int $awayTeam,
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'lineEntityId' => $this->lineEntityId,
            'lineEntityName' => $this->lineEntityName,
            'gamePeriodId' => $this->gamePeriodId,
            'gamePeriodName' => $this->gamePeriodName,
            'homeTeam' => $this->homeTeam,
            'awayTeam' => $this->awayTeam,
        ];
    }
}

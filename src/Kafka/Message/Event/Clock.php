<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

final class Clock implements \JsonSerializable
{
    public function __construct(
        protected ?int $startTimestamp = null,
        protected ?int $startSecond = null,
        protected ?bool $isStopped = null,
        protected ?bool $isCountdown = null,
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'startTimestamp' => $this->startTimestamp,
            'startSecond' => $this->startSecond,
            'isStopped' => $this->isStopped,
            'isCountdown' => $this->isCountdown,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Kafka\Message\Settlement;

final class Odd implements \JsonSerializable
{
    public function __construct(
        protected string $id,
        protected string $selectionStatus,
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'id' => $this->id,
            'selectionStatus' => $this->selectionStatus
        ];
    }
}

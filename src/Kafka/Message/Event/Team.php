<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

final class Team implements \JsonSerializable
{
    public function __construct(
        protected ?string $id = null,
        protected ?string $name = null,
        protected ?string $color = null
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color
        ];
    }
}

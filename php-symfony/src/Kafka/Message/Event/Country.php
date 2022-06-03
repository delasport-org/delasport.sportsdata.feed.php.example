<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

final class Country implements \JsonSerializable
{
    public function __construct(
        protected string $id,
        protected string $title,
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'id' => $this->id,
            'title' => $this->title
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

final class League implements \JsonSerializable
{
    public function __construct(
        protected string $id,
        protected string $title,
        protected string $format
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'format' => $this->format
        ];
    }
}

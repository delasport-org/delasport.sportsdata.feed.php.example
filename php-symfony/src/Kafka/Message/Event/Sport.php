<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

final class Sport implements \JsonSerializable
{
    public function __construct(
        protected string $id,
        protected string $title,
        protected string $key,
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
            'key' => $this->key
        ];
    }
}

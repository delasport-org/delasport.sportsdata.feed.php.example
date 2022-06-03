<?php

declare(strict_types=1);

namespace App\Kafka\Message\Market;

final class Odd implements \JsonSerializable
{
    public function __construct(
        protected string $id,
        protected ?string $key = null,
        protected ?string $value = null,
    ) {}

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return  [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value
        ];
    }
}

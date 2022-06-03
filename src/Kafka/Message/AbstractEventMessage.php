<?php

declare(strict_types=1);

namespace App\Kafka\Message;

abstract class AbstractEventMessage implements AsyncMessageInterface
{
    public function __construct(protected ?array $content) {}

    public function getContent(): ?array
    {
        return $this->content;
    }
}

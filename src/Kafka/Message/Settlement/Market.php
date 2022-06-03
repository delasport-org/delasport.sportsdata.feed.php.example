<?php

declare(strict_types=1);

namespace App\Kafka\Message\Settlement;

use Doctrine\Common\Collections\ArrayCollection;
use JetBrains\PhpStorm\ArrayShape;

final class Market implements \JsonSerializable
{
    protected ArrayCollection $odds;

    public function __construct(
        protected string $id,
        protected string $marketTypeId,
        protected string $gamePeriodId,
        protected string $lineEntityId
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
            'marketTypeId' => $this->marketTypeId,
            'gamePeriodId' => $this->gamePeriodId,
            'lineEntityId' => $this->lineEntityId,
            'odds' => $this->odds->toArray(),
        ];
    }
}

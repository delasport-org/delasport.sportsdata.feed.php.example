<?php

declare(strict_types=1);

namespace App\Kafka\Message\Event;

use Doctrine\Common\Collections\ArrayCollection;
use App\Kafka\Message\AsyncMessageInterface;

class EventMessage implements AsyncMessageInterface, \JsonSerializable
{
    protected ArrayCollection $liveScores;

    public function __construct(
        protected string $id,
        protected ?string $state = null,
        protected ?string $status = null,
        protected ?string $liveGamePeriod = null,
        protected ?string $liveMinute = null,
        protected ?int $marketCount = null,
        protected ?string $startDate = null,
        protected ?bool $hasLiveStreaming = null,
        protected ?string $invalidatedAt = null,
        protected ?string $timeRange = null,
        protected ?Country $country = null,
        protected ?Sport $sport = null,
        protected ?League $league = null,
        protected ?Clock$clock = null,
        protected ?Team $awayTeam = null,
        protected ?Team $homeTeam = null,
    ) {
        $this->liveScores = new ArrayCollection();
    }

    public function addLiveScore(LiveScore $score): void
    {
        $this->liveScores->add($score);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'state ' => $this->state ,
            'status ' => $this->status ,
            'liveGamePeriod' => $this->liveGamePeriod,
            'liveMinute' => $this->liveMinute,
            'marketCount' => $this->marketCount,
            'startDate' => $this->startDate,
            'hasLiveStreaming' => $this->hasLiveStreaming,
            'invalidatedAt' => $this->invalidatedAt,
            'timeRange' => $this->timeRange,
            'country' => $this->country?->toArray(),
            'sport' => $this->sport?->toArray(),
            'league' => $this->league?->toArray(),
            'clock' => $this->clock?->toArray(),
            'awayTeam' => $this->awayTeam?->toArray(),
            'homeTeam' => $this->homeTeam?->toArray(),
        ];
    }

    public static function createFromArray(array $data): self
    {
        $message = new self(
            $data['id'],
            $data['state'],
            $data['status'] ?? null,
            $data['liveGamePeriod'] ?? null,
            $data['liveMinute'] ?? null,
            $data['marketCount'] ?? null,
            $data['startDate'] ?? null,
            $data['hasLiveStreaming'] ?? null,
            $data['invalidatedAt'] ?? null,
            $data['timeRange'] ?? null,
            empty($data['country']) ? null : new Country(
                $data['id'] ?? '', $data['title'] ?? ''),
            empty($data['country']) ? null : new Sport(
                $data['id'] ?? '', $data['title'] ?? '', $data['key'] ?? ''),
            empty($data['league']) ? null : new League(
                $data['id'] ?? '', $data['title'] ?? '', $data['format'] ?? ''),
            empty($data['clock']) ? null : new Clock(
                $data['startTimestamp'] ?? null,
                $data['startSecond'] ?? null,
                $data['isStopped'] ?? null,
                $data['isCountdown'] ?? null),
            empty($data['awayTeam']) ? null : new Team(
                $data['id'] ?? null, $data['name'] ?? null, $data['color'] ?? null),
            empty($data['homeTeam']) ? null : new Team(
                $data['id'] ?? null, $data['name'] ?? null, $data['color'] ?? null),
        );

        foreach ($data['liveScores'] ?? [] as $score) {
            $message->addLiveScore(new LiveScore(
                $score['lineEntityId'],
                $score['lineEntityName'],
                $score['gamePeriodId'],
                $score['gamePeriodName'],
                $score['homeTeam'],
                $score['awayTeam'],
            ));
        }

        return $message;
    }

    public function getContent(): array
    {
        return $this->toArray();
    }
}

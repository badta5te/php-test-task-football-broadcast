<?php
namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private int $number;
    private string $name;
    private string $position;
    private string $playStatus;
    private array $goals;
    private bool $yellowCard;
    private bool $redCard;
    private int $inMinute;
    private int $outMinute;

    public function __construct(int $number, string $name, string $position)
    {
        $this->number = $number;
        $this->name = $name;
        $this->position = $position;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->goals = [];
        $this->yellowCard = false;
        $this->redCard = false;
        $this->inMinute = 0;
        $this->outMinute = 0;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function addGoal(int $time): int
    {
        return $this->goals[] = $time;
    }

    public function getGoals(): array
    {
        return $this->goals;
    }

    public function addYellowCard(): bool
    {
        return $this->yellowCard = true;
    }

    public function addRedCard(): bool
    {
        return $this->redCard = true;
    }

    public function hasYellowCard(): bool
    {
        return $this->yellowCard;
    }

    public function hasRedCard(): bool
    {
        return $this->redCard;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if(!$this->outMinute) {
            return 0;
        }

        return $this->outMinute - $this->inMinute;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute - 1;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }

    public function finishMatch(int $minute): void
    {
        $this->outMinute = $minute + 1;
    }
}
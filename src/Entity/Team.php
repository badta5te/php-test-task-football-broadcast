<?php

namespace App\Entity;

class Team
{
    public const PLAYER_POSITION_GOALKEEPER  = 'В';
    public const PLAYER_POSITION_DEFENDER  = 'З';
    public const PLAYER_POSITION_MIDFIELDER  = 'П';
    public const PLAYER_POSITION_FORWARD  = 'Н';

    private string $name;
    private string $country;
    private string $logo;
    private array $statistic = [
        'Вратарь' => 0,
        'Защитник' => 0,
        'Полузащитник' => 0,
        'Нападающий' => 0
    ];
    /**
     * @var Player[]
     */
    private array $players;
    private string $coach;
    private int $goals;

    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }

    public function getStatsByPosition(): void
    {
        foreach ($this->getPlayers() as $player) {
            $playerPosition = $player->getPosition();

            switch ($playerPosition) {
                case self::PLAYER_POSITION_GOALKEEPER:
                    $this->statistic['Вратарь'] += $player->getPlayTime();
                    break;
                case self::PLAYER_POSITION_DEFENDER:
                    $this->statistic['Защитник'] += $player->getPlayTime();
                    break;
                case self::PLAYER_POSITION_MIDFIELDER:
                    $this->statistic['Полузащитник'] += $player->getPlayTime();
                    break;
                case self::PLAYER_POSITION_FORWARD:
                    $this->statistic['Нападающий'] += $player->getPlayTime();
                    break;
            }
        }
    }

    public function getStatistic(): array
    {
        $this->getStatsByPosition();
        return $this->statistic;
    }

    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }
}
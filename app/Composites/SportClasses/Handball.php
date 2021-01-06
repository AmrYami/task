<?php


namespace App\Composites\SportClasses;


use App\Contracts\CalculateData;
use App\Contracts\PlayerInfo;

class Handball implements CalculateData
{
// model for just split, set and get data
    /**
     * @var int
     */
    public int $totalPoints = 0;

    /**
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->totalPoints;
    }

    /**
     * @var PlayerInfo
     */
    private PlayerInfo $playerInfo;

    /**
     * Basketball constructor.
     * @param PlayerInfo $playerInfo
     */
    public function __construct(PlayerInfo $playerInfo)
    {
        $this->playerInfo = $playerInfo;
    }
    /**
     *manage data to set position and calc scores
     */
    public function calculate(): void
    {
        $currentPosition = $this->playerInfo->getPosition();
        if (!in_array($currentPosition, $this->playerInfo->getPOSITIONS()))
            throw new \RuntimeException("Position {$currentPosition} is invalid");
        $scorePlayer = array_combine(
            [
                1,
                $this->playerInfo->getGoalsMade(),
                $this->playerInfo->getGoalsReceived(),
            ],
            ($this->playerInfo->getPOINTSPOSITIONS())[$currentPosition]);
        $totalScore = $this->playerScoreCalc($scorePlayer);
        $this->totalPoints = $totalScore;
    }
    /**
     * @param $scorePlayer
     * @return float|int
     * multiply all items in array and then sum to get total
     */
    public function playerScoreCalc($scorePlayer)
    {
        $sum = [];
        foreach ($scorePlayer as $key => $value) {
            $sum[] = $key * $value;
        }
        $total = array_sum($sum);
        return $total;
    }
    /**
     * @return array
     */
    public function getPlayerInformation(): array
    {
        // TODO: Implement getPlayerInformation() method.
        return [
            'Name'          => $this->playerInfo->getName(),
            'NickName'      => $this->playerInfo->getNickName(),
            'Number'        => $this->playerInfo->getNumber(),
            'Team'          => $this->playerInfo->getTeam(),
            'Position'      => $this->playerInfo->getPosition(),
            'GoalsMade'     => $this->playerInfo->getGoalsMade(),
            'GoalsReceived' => $this->playerInfo->getGoalsReceived(),
            'TotalPoints' => $this->totalPoints,

        ];
    }
}

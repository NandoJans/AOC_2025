<?php

namespace core;

use InvalidArgumentException;

class Application
{
    private function getArguments(): array
    {
        global $argv;
        if (count($argv) < 2) {
            throw new InvalidArgumentException("No day specified!");
        } else if (count($argv) < 3) {
            throw new InvalidArgumentException("No puzzle specified!");
        }
        return [$argv[1], $argv[2]];
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getDayClass(int $day): string
    {
        return 'days\\Day_' . $day;
    }

    private function getDay(int $day): Day
    {
        $dayClass = $this->getDayClass($day);
        return new $dayClass();
    }

    private function getPuzzleMethod(int $puzzle): string
    {
        return 'puzzle_' . $puzzle;
    }

    private function runPuzzle(Day $day, int $puzzle): void
    {
        $puzzle = $this->getPuzzleMethod($puzzle);
        if (method_exists($day, $puzzle)) {
            $day->$puzzle();
        } else {
            throw new InvalidArgumentException("Invalid puzzle specified!");
        }
    }

    public function run(): void
    {
        [$day, $puzzle] = $this->getArguments();
        $day = $this->getDay($day);
        $this->runPuzzle($day, $puzzle);
    }
}
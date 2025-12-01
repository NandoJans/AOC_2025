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
        $instance = Autowire::start($dayClass);
        if ($instance instanceof Day) {
            return $instance;
        } else {
            throw new InvalidArgumentException("Invalid day specified!");
        }
    }

    private function getPuzzleMethod(int $puzzle): string
    {
        return 'puzzle_' . $puzzle;
    }

    private function getInput(Day $day, int $puzzle): array
    {
        $input = file_get_contents(__DIR__ . "/../input/day_{$day->getDay()}.txt");
        $inputParser = new InputParser($input);
        $day->handleInput($inputParser, $puzzle);
        return $inputParser->getOutput();
    }

    private function runPuzzle(Day $day, int $puzzle): string
    {
        $puzzleMethod = $this->getPuzzleMethod($puzzle);

        if (method_exists($day, $puzzleMethod)) {
            $input = $this->getInput($day, $puzzle);
            return $day->$puzzleMethod($input);

        } else {
            throw new InvalidArgumentException("Invalid puzzle specified!");
        }
    }

    private function displayOutput(string $output): void
    {
        echo "Result: ". $output . PHP_EOL;
    }

    public function run(): void
    {
        [$day, $puzzle] = $this->getArguments();
        $day = $this->getDay($day);
        $output = $this->runPuzzle($day, $puzzle);
        $this->displayOutput($output);
    }
}
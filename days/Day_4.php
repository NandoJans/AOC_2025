<?php

namespace days;

use core\Day;
use core\InputParser;

class Day_4 extends Day
{
    private const string TOILET_PAPER = '@';
    private const string FOUND = 'X';
    private const string EMPTY = '.';

    private array $isToiletPaperCache = [];

    public function getDay(): int
    {
        return 4;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        $inputParser->explode();
        $inputParser->splitLines();
    }

    private function coordinateIs(array $board, int $y, int $x, string $char): bool
    {
        if (isset($isToiletPaperCache[$y][$x])) return $isToiletPaperCache[$y][$x];
        if (!array_key_exists($y, $board)) return false;
        if (!array_key_exists($x, $board[$y])) return false;

        return $board[$y][$x] === $char;
    }

    private function getAdjacentAmount(array $board, int $y, int $x): int
    {
        $count = 0;
        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                if ($i === 0 && $j === 0) continue;
                if ($this->coordinateIs($board, $y + $i, $x + $j, static::TOILET_PAPER)) $count++;
            }
        }
        return $count;
    }

    public function puzzle_1(array $input): string
    {
        $result = 0;

        foreach ($input as $y => $lineY) {
            foreach ($lineY as $x => $value) {
                if ($value !== static::TOILET_PAPER) continue;

                if ($this->getAdjacentAmount($input, $y, $x) < 4) {
                    $result++;
                }
            }
        }

        return $result;
    }

    private function getCoordinatesFor(array $board, string $char): array
    {
        $result = [];
        foreach ($board as $y => $lineY) {
            foreach ($lineY as $x => $value) {
                if ($value === $char) $result[] = [$y, $x];
            }
        }
        return $result;
    }

    public function puzzle_2(array $input): string
    {
        $result = 0;
        $roleOfPaperCoordinates = $this->getCoordinatesFor($input, static::TOILET_PAPER);
        $removed = 1;

        while ($removed > 0) {
            $removed = 0;

            foreach ($roleOfPaperCoordinates as $index => [$y, $x]) {
                if ($this->getAdjacentAmount($input, $y, $x) < 4) {
                    unset($roleOfPaperCoordinates[$index]);
                    $input[$y][$x] = static::EMPTY;
                    $this->isToiletPaperCache[$y][$x] = false;
                    $removed++;
                }
            }
            $result += $removed;
        }

        return $result;
    }
}
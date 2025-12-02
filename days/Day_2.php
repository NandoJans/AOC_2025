<?php

namespace days;

use core\Day;
use core\InputParser;

class Day_2 extends Day
{
    public function getDay(): int
    {
        return 2;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        $inputParser->explodeWith(',');
        $inputParser->explodeLinesWith('-');
    }

    private function hasRepeatingDigitsTwice(string $line): bool
    {
        $length = strlen($line);
        if ($length % 2 === 1) {
            return false;
        }
        $halfLength = $length / 2;
        $substr1 = substr($line, 0, $halfLength);
        $substr2 = substr($line, $halfLength);
        return $substr1 === $substr2;
    }

    private function getInvalidIds1(string $start, string $end): array
    {
        return array_filter(range($start, $end), fn($item) => $this->hasRepeatingDigitsTwice($item));
    }

    public function puzzle_1(array $input): string
    {
        $total = 0;
        foreach ($input as $line) {
            $invalids = $this->getInvalidIds1($line[0], $line[1]);
            $total += array_sum($invalids);
        }
        return $total;
    }

    private function checkPattern(string $line, string $pattern): bool
    {
        return str_replace($pattern, '', $line) === '';
    }

    private function hasRepeatingDigits(string $line): bool
    {
        // Scout for similar digit.
        $halfWay = strlen($line) / 2;
        $charMap = str_split($line);
        $first = array_shift($charMap);
        $pattern = $first;
        foreach ($charMap as $index => $digit) {
            $realIndex = $index + 1;
            // When the scouting goes past the half way point, we know that there are no repeating digits.
            if ($realIndex > $halfWay) return false;
            // When the digit is the same as the first, we need to check if the pattern persists.
            if ($digit === $first && $this->checkPattern($line, $pattern)) {
                return true;
            }
            $pattern .= $digit;
        }

        return false;
    }

    private function getInvalidIds2(string $start, string $end): array
    {
        return array_filter(range($start, $end), fn($item) => $this->hasRepeatingDigits($item));
    }

    public function puzzle_2(array $input): string
    {
        $total = 0;
        foreach ($input as $line) {
            $invalids = $this->getInvalidIds2($line[0], $line[1]);
            $total += array_sum($invalids);
        }
        return $total;
    }
}
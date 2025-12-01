<?php

namespace days;

use core\Day;

class Day_1 extends Day
{
    public function getDay(): int
    {
        return 1;
    }

    private function correctNumber(int $number): int
    {
        // 100 => 0 and -1 => 99;
        $number = $number % 100;
        if ($number < 0) {
            $number += 100;
        }
        return $number;
    }

    private function getValueDirection(string $line): int
    {
        if (str_starts_with($line, 'R')) {
            return (int) str_replace('R', '', $line);
        } elseif (str_starts_with($line, 'L')) {
            return -(int) str_replace('L', '', $line);
        }
        return 0;
    }

    public function puzzle_1(array $input): string
    {
        $value = 50;
        $zeroCount = 0;
        foreach ($input as $line) {
            $value = $this->correctNumber($value + $this->getValueDirection($line));
            if ($value === 0) {
                $zeroCount++;
            }
        }
        return $zeroCount;
    }

    public function puzzle_2(array $input): string
    {
        return '';
    }
}
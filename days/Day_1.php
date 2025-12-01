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
        $value = 50;
        $zeroCount = 0;
        foreach ($input as $line) {
            echo PHP_EOL;
            echo "Line: $line" . PHP_EOL;
            echo "Value: $value" . PHP_EOL;
            $newValue = $value + $this->getValueDirection($line);
            echo "New Value: $newValue" . PHP_EOL;
            // 138 / 100 = 1
            if ($newValue > 99 || $newValue < 0) {
                echo "Zero's count: " . abs(floor($newValue / 100)) . PHP_EOL;
                $zeroCount += abs(floor($newValue / 100));
                if ($newValue < 0 && $value === 0) {
                    echo "Zero's count: -1" . PHP_EOL;
                    $zeroCount--;
                }
            } elseif ($newValue === 0) {
                echo "Zero's count: 1" . PHP_EOL;
                $zeroCount++;
            }
            $value = $this->correctNumber($newValue);
            echo "Corrected Value: $value" . PHP_EOL;
            echo "Zero Count: $zeroCount" . PHP_EOL;
            echo PHP_EOL;
        }
        return $zeroCount;
    }
}
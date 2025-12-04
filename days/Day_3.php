<?php

namespace days;

use core\Day;
use core\InputParser;

class Day_3 extends Day
{
    public function getDay(): int
    {
        return 3;
    }

    private function findLargestDigit(string $line): array
    {
        [$largestIndex, $largestDigit] = [0, 0];

        foreach (str_split($line) as $index => $digit) {
            // When we find a nine, we should return immediately
            if ($digit == 9) {
                return [$index, $digit];
            }
            // When the digit is larger then the largest digit, save it.
            if ($digit > $largestDigit) {
                [$largestIndex, $largestDigit] = [$index, $digit];
            }
        }
        return [$largestIndex, $largestDigit];
    }

    private function findLargestNumberForLength(string $line, int $length): int
    {
        $digitString = '';
        $index = 0;
        for ($i = 0; $i < $length; $i++) {
            $substrLength = $i-$length+1;
            $substr = substr(
                $line,
                $index,
                ($substrLength === 0) ? null : $substrLength
            );
            [$digitIndex, $digit] = $this->findLargestDigit($substr);
            $index = $index + $digitIndex + 1;
            $digitString .= $digit;
        }
        return $digitString;
    }

    private function handleIteration(array $input, int $length): int
    {
        return array_sum(array_map(fn($item) => $this->findLargestNumberForLength($item, $length), $input));
    }

    public function puzzle_1(array $input): string
    {
        return $this->handleIteration($input, 2);
    }

    public function puzzle_2(array $input): string
    {
        return $this->handleIteration($input, 12);
    }
}
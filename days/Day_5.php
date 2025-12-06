<?php

namespace days;

use core\Day;
use core\InputParser;
use Couchbase\ValueRecorder;

class Day_5 extends Day
{

    public function getDay(): int
    {
        return 5;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        $inputParser->explodeWith("\n\r");
        $inputParser->explodeLinesWith("\n");
        $inputParser->customHandler(function (array $output, string $input) {
            $output[0] = array_map(fn($item) => explode('-', $item), $output[0]);
            return $output;
        });
    }

    public function puzzle_1(array $input): string
    {
        $result = 0;
        $ranges = $input[0];
        $ingredientIds = $input[1];
        foreach ($ingredientIds as $ingredientId) {
            foreach ($ranges as [$min, $max]) {
                if ($ingredientId >= $min && $ingredientId <= $max) {
                    $result++;
                    break;
                }
            }
        }
        return $result;
    }

    private function getNewRange(int $min1, int $max1, int $min2, int $max2): array
    {
        return [
            ($min1 >= $min2) ? $min2 : $min1,
            ($max1 >= $max2) ? $max1 : $max2
        ];
    }

    public function puzzle_2(array $input): string
    {
        $result = 0;
        $ranges = $input[0];
        $skipRanges = [];
        $changed = true;
        // Calculate the real existing ranges.
        while ($changed) {
            $changed = false;
            foreach ($ranges as $index1 => [$min1, $max1]) {
                if (in_array($index1, $skipRanges)) continue;
                foreach ($ranges as $index2 => [$min2, $max2]) {
    //                if (array_key_exists())
                    if (in_array($index2, $skipRanges)) continue;
                    if ($index1 === $index2) continue;

                    if ($max1 >= $min2 && $min2 >= $min1 || $min1 <= $max2 && $max2 <= $max1) {
                        [$min1, $max1] = $this->getNewRange($min1, $max1, $min2, $max2);

                        unset($ranges[$index2]);
                        $skipRanges[] = $index2;
                        $changed = true;
                    }
                }
                $ranges[$index1] = [$min1, $max1];
            }
        }

        foreach ($ranges as [$min, $max]) {
            $diff = $max - $min + 1;
            $result += $diff;
        }
//        var_dump($ranges);
        // Determine the amount of fresh ingredients by subtract min from max.
        return $result;
    }
}
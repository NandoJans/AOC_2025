<?php

namespace days;

use classes\JunctionBox;
use core\Board;
use core\Day;
use core\InputParser;
use core\Sorter;
use core\Space;

class Day_9 extends Day
{
    public function getDay(): int
    {
        return 9;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        $inputParser->explode();
        $inputParser->explodeLinesWith(',');
    }

    private function getRectangleAreas(array $input): array
    {
        $areas = [];
        foreach ($input as $i1 => $tile1) {
            foreach ($input as $i2 => $tile2) {
                if ($i1 === $i2) continue;
                $tile1i = $tile1[0];
                $tile1j = $tile1[1];
                $tile2i = $tile2[0];
                $tile2j = $tile2[1];
                $area = Board::getArea($tile1i, $tile1j, $tile2i, $tile2j, 1);
                $areas[] = [
                    $tile1,
                    $tile2,
                    $area
                ];
            }
        }
        usort($areas, function ($a, $b) {
            return -($a[2] <=> $b[2]);
        });
        return $areas;
    }

    public function puzzle_1(array $input): string
    {
        return $this->getRectangleAreas($input)[0][2];
    }

    private function tileBeyondCornerExists(array $corner, string $cornerType, array $input): bool
    {
        if (!$cornerType) return false;

        $comparison = match ($cornerType) {
            Board::TOP_RIGHT => fn($a, $b) => $a[0] >= $b[0] && $a[1] <= $b[1],
            Board::BOTTOM_RIGHT => fn($a, $b) => $a[0] <= $b[0] && $a[1] <= $b[1],
            Board::TOP_LEFT => fn($a, $b) => $a[0] >= $b[0] && $a[1] >= $b[1],
            Board::BOTTOM_LEFT => fn($a, $b) => $a[0] <= $b[0] && $a[1] >= $b[1],
        };
        foreach ($input as $tile) {
            if ($result = $comparison($corner, $tile)) {
                echo "Found tile larger than corner: $tile[0], $tile[1]".PHP_EOL;
                return $result;
            }
        }
        return false;
    }

//    public function puzzle_2(array $input): string
//    {
//        $result = 0;
//        $rectangles = $this->getRectangleAreas($input);
//        $tileCache = array_map(fn($tile) => Board::encodeLocationArr($tile), $input);
//
//        foreach ($rectangles as $rectangle) {
//            // Determine if the other corners are valid corners by.
//            // 1. Checking if the corner exists in the tile cache.
//            // 2. If not, check if any corner's coordinate >= to the propable up, right, down, left
//
//            $corner1 = [$rectangle[0][0], $rectangle[1][1]];
//            if (!in_array(Board::encodeLocationArr($corner1), $tileCache)) {
//                // Determine if the corner is top-right, bottom-right, bottom-left, top-left.
//                $cornerType = Board::determineCorner($corner1, $rectangle[0], $rectangle[1]);
//                echo "$corner1[0], $corner1[1] against {$rectangle[0][0]}, {$rectangle[0][1]} and {$rectangle[1][0]}, {$rectangle[1][1]} has corner type $cornerType".PHP_EOL;
//                if (!$cornerType || !$this->tileBeyondCornerExists($corner1, $cornerType, $input)) {
//                    echo "This corner is invalid!".PHP_EOL;
//                    continue;
//                }
//            }
//
//            $corner2 = [$rectangle[1][0], $rectangle[0][1]];
//            if (!in_array(Board::encodeLocationArr($corner2), $tileCache)) {
//                $cornerType = Board::determineCorner($corner2, $rectangle[0], $rectangle[1]);
//                if (!$cornerType || !$this->tileBeyondCornerExists($corner2, $cornerType, $input)) {
//                    continue;
//                }
//            }
//
//            $result = $rectangle[2];
//            break;
//        }
//
//        return $result;
//    }

    private function getBordersFromPoints(array $points): array
    {
        [$imin, $imax, $jmin, $jmax] = [999999, 0, 999999, 0];

        foreach ($points as [$i, $j]) {
            if ($i < $imin) {
                $imin = $i;
            } elseif ($i > $imax) {
                $imax = $i;
            }
            if ($j < $jmin) {
                $jmin = $j;
            } elseif ($j > $jmax) {
                $jmax = $j;
            }
        }

        return [$imin, $imax, $jmin, $jmax];
    }

    public function puzzle_2(array $input): string
    {
        $borders = $this->getBordersFromPoints($input);
        var_dump($borders);
        return 0;
    }
}
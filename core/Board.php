<?php

namespace core;

class Board
{
    public const string TOP_RIGHT = 'top-right';
    public const string TOP_LEFT = 'top-left';
    public const string BOTTOM_RIGHT = 'bottom-right';
    public const string BOTTOM_LEFT = 'bottom-left';

    public function __construct(
        private array $board
    )
    {
    }

    public function isValidLocation(int $i, int $j): bool
    {
        return array_key_exists($i, $this->board) && array_key_exists($j, $this->board[$i]);
    }

    public function findCharLocations(string $char, ?int $limit = null): array
    {
        $locations = [];
        foreach ($this->board as $i => $col) {
            foreach ($col as $j => $item) {
                if ($item === $char) {
                    $locations[] = [$i, $j];
                    if ($limit !== null && $limit <= sizeof($locations)) {
                        return $locations;
                    }
                }
            }
        }
        return $locations;
    }

    public function getLocationChar(int $i, int $j): ?string
    {
        if ($this->isValidLocation($i, $j)) {
            return $this->board[$i][$j];
        } else {
            return null;
        }
    }

    public function setLocationChar(int $i, int $j, string $char): void
    {
        if ($this->isValidLocation($i, $j)) {
            $this->board[$i][$j] = $char;
        }
    }

    public static function encodeLocation(int $i, int $j): string
    {
        return "$i,$j";
    }

    public static function encodeLocationArr(array $ij): string
    {
        return static::encodeLocation($ij[0], $ij[1]);
    }

    public static function getDelta(int $i, int $j, int $offset = 0): int
    {
        return abs($i - $j) + $offset;
    }

    public static function getArea(int $i1, int $j1, int $i2, int $j2, int $deltaOffset = 0): int
    {
        return static::getDelta($i1, $i2, $deltaOffset) * static::getDelta($j1, $j2, $deltaOffset);
    }

    public static function determineCorner(array $corner1, array $corner2, array $corner3): ?string
    {
        $topBottom = '';
        if (
            $corner1[0] === $corner2[0] && $corner1[0] > $corner3[0] ||
            $corner1[0] === $corner3[0] && $corner1[0] > $corner2[0]
        ) {
            $topBottom = 'bottom';
        } elseif (
            $corner1[0] === $corner2[0] && $corner1[0] < $corner3[0] ||
            $corner1[0] === $corner3[0] && $corner1[0] < $corner2[0]
        ) {
            $topBottom = 'top';
        }

        if (!$topBottom) return null;

        $rightLeft = '';
        if (
            $corner1[1] === $corner2[1] && $corner1[1] > $corner3[1] ||
            $corner1[1] === $corner3[1] && $corner1[1] > $corner2[1]
        ) {
            $rightLeft = 'right';
        } elseif (
            $corner1[1] === $corner2[1] && $corner1[1] < $corner3[1] ||
            $corner1[1] === $corner3[1] && $corner1[1] < $corner2[1]
        ) {
            $rightLeft = 'left';
        }

        if (!$rightLeft) return null;
        return "$topBottom-$rightLeft";
    }

    public function __toString(): string
    {
        $str = '';
        foreach ($this->board as $row) {
            $str .= implode('', $row) . PHP_EOL;
        }
        return $str;
    }
}
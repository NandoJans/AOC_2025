<?php

namespace core;

class Board
{
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

    public function __toString(): string
    {
        $str = '';
        foreach ($this->board as $row) {
            $str .= implode('', $row) . PHP_EOL;
        }
        return $str;
    }
}
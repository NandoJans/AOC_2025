<?php

namespace days;

use core\Board;
use core\Day;
use core\InputParser;

class Day_7 extends Day
{
    private const string START = 'S';
    private const string EMPTY = '.';
    private const string SPLITTER = '^';

    public function getDay(): int
    {
        return 7;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        parent::handleInput($inputParser, $puzzle);
        $inputParser->splitLines();
    }

    public function travelBeam(Board $board, int $i, int $j): array
    {
        if ($char = $board->getLocationChar($i, $j)) {
            if ($char === self::SPLITTER) {
                $splitting = [Board::encodeLocation($i, $j) => [$i, $j]];

                if ($board->getLocationChar($i, $j+1) === self::EMPTY) {
                    $splitting = [
                        ...$splitting,
                        ...$this->travelBeam($board, $i, $j+1)
                    ];
                }

                if ($board->getLocationChar($i, $j-1) === self::EMPTY) {
                    $splitting = [
                        ...$splitting,
                        ...$this->travelBeam($board, $i, $j-1)
                    ];
                }

                return $splitting;
            } elseif ($char === self::EMPTY) {
                $board->setLocationChar($i, $j, '|');
                return $this->travelBeam($board, $i+1, $j);
            }
        }
        return [];
    }

    public function puzzle_1(array $input): string
    {
        $board = new Board($input);
        $startLocation = $board->findCharLocations(self::START, 1);
        if (!$startLocation) return 0;

        $result = $this->travelBeam($board, $startLocation[0][0]+1, $startLocation[0][1]);
        return sizeof($result);
    }

    private array $travelCache = [];

    private function travelBeamOnce(Board $board, int $i, int $j): int
    {
        if ($char = $board->getLocationChar($i, $j)) {
            if ($char === self::SPLITTER) {
                $locationStr = Board::encodeLocation($i, $j);
                if (array_key_exists($locationStr, $this->travelCache)) {
                    return $this->travelCache[$locationStr];
                } else {
                    $result = $this->travelBeamOnce($board, $i, $j+1) + $this->travelBeamOnce($board, $i, $j-1);
                    $this->travelCache[$locationStr] = $result;
                    return $result;
                }
            } elseif ($char === self::EMPTY) {
                return $this->travelBeamOnce($board, $i+1, $j);
            }
        }
        return 1;
    }

    public function puzzle_2(array $input): string
    {
        $board = new Board($input);
        $startLocation = $board->findCharLocations(self::START, 1);
        if (!$startLocation) return 0;

        $result = $this->travelBeamOnce($board, $startLocation[0][0]+1, $startLocation[0][1]);
        return $result;
    }
}
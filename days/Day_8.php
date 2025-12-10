<?php

namespace days;

use classes\JunctionBox;
use core\Board;
use core\Day;
use core\InputParser;
use core\Sorter;
use core\Space;

class Day_8 extends Day
{
    public function __construct(
        private readonly Sorter $sorter
    )
    {
    }

    public function getDay(): int
    {
        return 8;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        $inputParser->explode();
        $inputParser->explodeLinesWith(',');
    }

    private function initSpace(array $input): Space
    {
        $space = new Space();
        $space->addPoints($input);
        $space->initDistances();
        return $space;
    }

    private function getCircuitsFromSpace(Space $space): array
    {
        $circuits = [];
        foreach ($space->getPoints() as $index => $point) {
            $circuits[$index] = [$point->setCircuit($index)];
        }
        return $circuits;
    }

    private function mergeCircuits(array $circuits, int $circuitId1, int $circuitId2): array
    {
        $circuits[$circuitId1] = [
            ...$circuits[$circuitId1],
            ...$circuits[$circuitId2]
        ];
        unset($circuits[$circuitId2]);
        foreach ($circuits[$circuitId1] as $point) {
            $point->setCircuit($circuitId1);
        }
        return $circuits;
    }

    private function getResultFromCircuits(array $circuits, int $length): int
    {
        $result = 1;
        foreach (array_slice($circuits, 0, $length) as $circuit) {
            $result *= sizeof($circuit);
        }
        return $result;
    }

    public function puzzle_1(array $input): string
    {
        $space = $this->initSpace($input);
        $distances = array_merge($space->getDistances(1000));
        $circuits = $this->getCircuitsFromSpace($space);

        foreach ($distances as [$distance, $point1, $point2]) {
            if ($point1->getCircuit() === $point2->getCircuit()) {
                continue;
            }
            $circuits = $this->mergeCircuits($circuits, $point1->getCircuit(), $point2->getCircuit());
        }

        $circuits = $this->sorter->sortByArraySize($circuits);

        return $this->getResultFromCircuits($circuits, 3);
    }

    public function puzzle_2(array $input): string
    {
        $space = $this->initSpace($input);
        $distances = array_merge($space->getDistances());
        $circuits = $this->getCircuitsFromSpace($space);

        $result = 0;

        foreach ($distances as [$distance, $point1, $point2]) {
            if ($point1->getCircuit() === $point2->getCircuit()) {
                continue;
            }
            $circuits = $this->mergeCircuits($circuits, $point1->getCircuit(), $point2->getCircuit());
            if (sizeof($circuits) === 1) {
                $result = $point1->x * $point2->x;
                break;
            }
        }

        return $result;
    }
}
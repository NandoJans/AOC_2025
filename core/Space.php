<?php

namespace core;

use classes\JunctionBox;

class Space
{
    /** @var JunctionBox[] $points */
    protected array $points = [];
    protected array $distances = [];

    public function getPoints(): array
    {
        return $this->points;
    }

    public function getDistances(?int $limit = null): array
    {
        if ($limit !== null) {
            return array_slice($this->distances, 0, $limit);
        }
        return $this->distances;
    }

    public function addPoints(array $points): void
    {
        foreach ($points as [$x, $y, $z]) {
            $this->points[] = new JunctionBox($x, $y, $z);
        }
    }

    public function initDistances(): void
    {
        foreach ($this->points as $index1 => $point1) {
            foreach ($this->points as $index2 => $point2) {
                if ($index1 <= $index2) continue;
                $distance = $point1->getDistanceTo($point2);
                $this->distances[] = [$distance, $point1, $point2];
            }
        }
        $this->sortDistances($this->distances);
    }

//    public function initDistances(): void
//    {
//        foreach ($this->points as $index1 => $point1) {
//            $this->distances[$point1->__toString()] = [];
//            foreach ($this->points as $index2 => $point2) {
//                if ($index1 === $index2) continue;
//                $distance = $point1->getDistanceTo($point2);
//                $this->distances[$point1->__toString()][] = [$distance, $point1, $point2];
//            }
//            $this->sortDistances($this->distances[$point1->__toString()]);
//        }
//    }

    public function getDistancesForPoint(JunctionBox $point): array
    {
        return $this->distances[$point->__toString()];
    }

    public function sortDistances(array &$distances): void
    {
        usort($distances, function ($a, $b) {
            return $a[0] <=> $b[0];
        });
    }
}
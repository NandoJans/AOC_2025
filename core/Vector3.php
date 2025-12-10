<?php

namespace core;

class Vector3
{
    public function __construct(
        public int $x,
        public int $y,
        public int $z
    )
    {
    }

    public static function getDistance(Vector3 $vec1, Vector3 $vec2): float
    {
        return sqrt(
            ($vec2->x - $vec1->x)**2 +
            ($vec2->y - $vec1->y)**2 +
            ($vec2->z - $vec1->z)**2
        );
    }

    public function getDistanceTo(Vector3 $vec2): float
    {
        return Vector3::getDistance($this, $vec2);
    }

    public function __toString(): string
    {
        return "($this->x, $this->y, $this->z)";
    }
}
<?php

namespace classes;

use core\Vector3;

class JunctionBox extends Vector3
{
    protected ?int $circuit = null;

    public function hasCircuit(): bool
    {
        return $this->circuit !== null;
    }

    public function getCircuit(): ?int
    {
        return $this->circuit;
    }

    public function setCircuit(int $circuit): static
    {
        $this->circuit = $circuit;
        return $this;
    }
}
<?php

namespace core;

abstract class Day
{
    abstract public function getDay(): int;

    abstract public function puzzle_1(array $input): string;
    abstract public function puzzle_2(array $input): string;

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        $inputParser->explode();
    }
}
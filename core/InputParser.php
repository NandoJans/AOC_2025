<?php

namespace core;

class InputParser
{
    private array $output;

    public function __construct(
        private readonly string $input
    ) {}

    public function explodeLines(): void
    {
        $this->output = explode("\n", $this->input);
    }

    public function getOutput(): array
    {
        return $this->output;
    }
}
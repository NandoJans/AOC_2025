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

    public function explodeWith(string $string): void
    {
        $this->output = explode($string, $this->input);
    }

    public function explodeLinesWith(string $string): void
    {
        $this->iterate(fn($line) => explode($string, $line));
    }

    public function iterate(callable $callback): void
    {
        foreach ($this->output as $index => $line) {
            $this->output[$index] = $callback($line);
        }
    }

    public function getOutput(): array
    {
        return $this->output;
    }
}
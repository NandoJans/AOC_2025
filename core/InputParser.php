<?php

namespace core;

class InputParser
{
    private array $output = [];

    public function __construct(
        private readonly string $input
    ) {}

    public function explode(): void
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

    public function customHandler(callable $function): void
    {
        $this->output = $function($this->output, $this->input);
    }

    public function splitLines(): void
    {
        $this->iterate(fn($line) => str_split($line));
    }

    public function iterate(callable $callback): void
    {
        foreach ($this->output as $index => $line) {
            $this->output[$index] = $callback($line);
        }
    }

    public function rotate(): void
    {
        $rotated = [];
        $length = sizeof($this->output[0]);
        for ($i = 0; $i < $length; $i++) {
            $rotatedI = [];
            foreach ($this->output as $item) {
                $rotatedI[] = $item[$i];
            }
            $rotated[$i] = $rotatedI;
        }
        $this->output = $rotated;
    }

    public function clean(): void
    {
        $this->output = $this->cleanOutput($this->output);
    }

    private function cleanOutput(array $output): array
    {
        return array_merge(array_filter(array_map(function ($item) {
            if (is_array($item)) {
                return $this->cleanOutput($item);
            } else {
                return str_replace(["\n", "\r"], '', $item);
            }
        }, $output), function ($item) {
            return $item !== '';
        }));
    }

    public function getOutput(): array
    {
        return $this->cleanOutput($this->output);
    }
}
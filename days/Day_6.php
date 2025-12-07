<?php

namespace days;

use core\Day;
use core\InputParser;

class Day_6 extends Day
{

    public function getDay(): int
    {
        return 6;
    }

    public function handleInput(InputParser $inputParser, int $puzzle): void
    {
        if ($puzzle == 2) {
            $inputParser->customHandler(function (array $output, string $input) {
                return $this->handlePuzzle2Input($output, $input);
            });
            $inputParser->clean();
        } else {
            $inputParser->explodeWith("\n");
            $inputParser->explodeLinesWith(" ");
            $inputParser->clean();
            $inputParser->rotate();
        }
    }

    private function applyFunction(array $items, callable $function): int
    {
        $result = array_shift($items);
        for ($i = 0; $i < sizeof($items); $i++) {
            $result = $function($result, $items[$i]);
        }
        return $result;
    }

    private function applySymbolToValues(string $symbol, array $items): int
    {
        return match ($symbol) {
            '+' => array_sum($items),
            '*' => $this->applyFunction($items, fn($a, $b) => $a * $b),
            default => 0
        };
    }

    public function puzzle_1(array $input): string
    {
        $result = 0;
        foreach ($input as $items) {
            $result += $this->applySymbolToValues(array_pop($items), $items);
        }
        return $result;
    }

    private function findLengthsFor(string $input): array
    {
        $chars = str_split($input);
        $lengths = [];
        $length = 0;
        $i = 0;
        foreach ($chars as $char) {
            $currentI = $i;
            if (in_array($char, ["\n", "\r", "*", "+"])) {
                $i = 0;

            } elseif ($char !== " ") {
                $length++;
                continue;
            }
            if ($length > 0) {
                if (array_key_exists($currentI, $lengths)) {
                    if ($lengths[$currentI] < $length) {
                        $lengths[$currentI] = $length;
                    }
                } else {
                    $lengths[$currentI] = $length;
                }
                $length = 0;
                if ($currentI === $i) $i++;
            }
        }
        return $lengths;
    }

    private function getLinesForLengths(string $input, array $lengths): array
    {
        $explodedInput = explode("\r\n", $input);
        $lines = [];
        foreach ($explodedInput as $line) {
            $charI = 0;
            foreach ($lengths as $i => $length) {
                if (!array_key_exists($i, $lines)) $lines[$i] = [];
                $lines[$i][] = str_pad(substr($line, $charI, $length), $length);
                $charI += $length + 1;
            }
        }
        return $lines;
    }

    private function handlePuzzle2Input(array $output, string $input): array
    {
        $lengths = $this->findLengthsFor($input);
        $lines = $this->getLinesForLengths($input, $lengths);

        foreach ($lines as $line) {
            $symbol = array_pop($line);
            $realLine = [];
            for ($j = 0; $j < strlen($line[0]); $j++) {
                $item = '';
                for ($i = 0; $i < sizeof($line); $i++) {
                    $item .= $line[$i][$j];
                }
                $realLine[] = str_replace(' ', '', $item);
            }
            $realLine[] = str_replace(' ', '', $symbol);;
            $output[] = $realLine;
        }

        return $output;
    }

    public function puzzle_2(array $input): string
    {
        return $this->puzzle_1($input);
    }
}
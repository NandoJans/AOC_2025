<?php

namespace core;

class Display
{
    public const string ICON_CHECK = '✅';
    public const string ICON_STOPWATCH = '⏱️';

    public const string TEXT_COLOR_GREEN = "\033[32m";
    public const string TEXT_COLOR_BLUE = "\033[94m";
    public const string TEXT_COLOR_BLACK = "\033[30m";

    public const string BG_COLOR_YELLOW = "\033[43m";
    public const string BG_COLOR_RED = "\033[41m";
    public const string BG_COLOR_GREEN = "\033[42m";
    public const string BG_COLOR_PURPLE = "\033[45m";

    public const string RESET = "\033[0m";

    public function displayTitle(string $title): void
    {
        echo self::BG_COLOR_PURPLE . self::TEXT_COLOR_BLACK . PHP_EOL;
        echo PHP_EOL;
        echo " {$title} " . PHP_EOL;
        echo self::RESET . PHP_EOL;
    }

    public function emptyLine(int $repeat = 1): void
    {
        echo str_repeat(PHP_EOL, $repeat);
    }

    public function line(string $string, bool $resets = true): void
    {
        echo $string . PHP_EOL . ($resets ? self::RESET : '');
    }

}
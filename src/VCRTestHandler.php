<?php
declare(strict_types=1);

namespace VCR\PHPUnit\TestListener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use VCR\VCR;

final class VCRTestHandler
{
    private function __construct() {}

    public static function onStart(string $class, string $method): void
    {
        if (!method_exists($class, $method)) {
            return;
        }

        $reflection = new \ReflectionMethod($class, $method);
        $docBlock = $reflection->getDocComment();

        // Use regex to parse the doc_block for a specific annotation
        $parsed = self::parseDocBlock($docBlock, '@vcr');
        $cassetteName = array_pop($parsed);

        if (empty($cassetteName)) {
            return;
        }

        // If the cassette name ends in .json, then use the JSON storage format
        if (substr($cassetteName, -5) === '.json') {
            VCR::configure()->setStorage('json');
        }

        VCR::turnOn();
        VCR::insertCassette($cassetteName);
    }

    public static function onEnd(): void
    {
        VCR::turnOff();
    }

    private static function parseDocBlock($docBlock, $tag): array
    {
        $matches = [];

        if (empty($docBlock)) {
            return $matches;
        }

        $regex = "/{$tag} (.*)(\\r\\n|\\r|\\n)/U";
        preg_match_all($regex, $docBlock, $matches);

        if (empty($matches[1])) {
            return array();
        }

        // Removed extra index
        $matches = $matches[1];

        // Trim the results, array item by array item
        foreach ($matches as $ix => $match) {
            $matches[$ix] = trim($match);
        }

        return $matches;
    }
}

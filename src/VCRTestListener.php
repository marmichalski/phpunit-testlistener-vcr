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

/**
 * A TestListener that integrates with PHP-VCR.
 *
 * Here is an example XML configuration for activating this listener in PHPUnit < 10.
 *
 * <code>
 *   <listeners>
 *     <listener class="VCR\PHPUnit\TestListener\VCRTestListener" file="vendor/php-vcr/phpunit-testlistener-vcr/src/VCRTestListener.php" />
 *   </listeners>
 * </code>
 *
 * @author    Adrian Philipp  <mail@adrian-philipp.com>
 * @author    Davide Borsatto <davide.borsatto@gmail.com>
 * @author    Renato Mefi     <gh@mefi.in>
 */
final class VCRTestListener implements TestListener
{
    public function startTest(Test $test): void
    {
        $class = \get_class($test);
        \assert($test instanceof TestCase);

        VCRTestHandler::onStart($class, $test->getName(false));
    }

    public function endTest(Test $test, float $time): void
    {
        VCRTestHandler::onEnd();
    }

    public function addError(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    public function addIncompleteTest(Test $test, \Throwable $e, float $time): void
    {
    }

    public function addSkippedTest(Test $test, \Throwable $e, float $time): void
    {
    }

    public function addRiskyTest(Test $test, \Throwable $e, float $time): void
    {
    }

    public function startTestSuite(TestSuite $suite): void
    {
    }

    public function endTestSuite(TestSuite $suite): void
    {
    }
}

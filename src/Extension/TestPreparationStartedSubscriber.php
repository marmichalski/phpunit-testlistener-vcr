<?php

declare(strict_types=1);

namespace VCR\PHPUnit\TestListener\Extension;

use PHPUnit\Event\Code\TestMethod;
use PHPUnit\Event\Test\PreparationStarted;
use PHPUnit\Event\Test\PreparationStartedSubscriber;
use VCR\PHPUnit\TestListener\VCRTestHandler;

final class TestPreparationStartedSubscriber implements PreparationStartedSubscriber
{
    public function notify(PreparationStarted $event): void
    {
        $testMethod = $event->test();
        if (!$testMethod instanceof TestMethod) {
            return;
        }

        VCRTestHandler::onStart($testMethod->className(), $testMethod->name());
    }
}

<?php

declare(strict_types=1);

namespace VCR\PHPUnit\TestListener\Extension;

use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;
use VCR\PHPUnit\TestListener\VCRTestHandler;

final class TestFinishedSubscriber implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        VCRTestHandler::onEnd();
    }
}

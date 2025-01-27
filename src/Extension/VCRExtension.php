<?php

declare(strict_types=1);

namespace VCR\PHPUnit\TestListener\Extension;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

/**
 * An Extension that integrates with PHP-VCR.
 *
 * Here is an example XML configuration for activating this listener in PHPUnit >= 10.
 *
 * <code>
 *   <extensions>
 *     <bootstrap class="VCR\PHPUnit\TestListener\VcrExtension" />
 *   </extensions>
 * </code>
 */
final class VCRExtension implements Extension
{
    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $facade->registerSubscribers(
            new TestPreparationStartedSubscriber(),
            new TestFinishedSubscriber()
        );
    }
}

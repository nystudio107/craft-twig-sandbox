<?php

namespace nystudio107\crafttwigsandbox\console;

use craft\console\ErrorHandler;
use Twig\Sandbox\SecurityError;

class SandboxErrorHandler extends ErrorHandler
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function handleException($exception): void
    {
        // If this is a Twig Runtime exception, use the previous one instead
        if ($exception instanceof SecurityError && ($previousException = $exception->getPrevious()) !== null) {
            $exception = $previousException;
        }
        parent::handleException($exception);
    }
}

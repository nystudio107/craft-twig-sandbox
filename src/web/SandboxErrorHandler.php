<?php

namespace nystudio107\crafttwigsandbox\web;

use craft\helpers\Template;
use craft\web\ErrorHandler;
use ReflectionMethod;
use Throwable;
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

    /**
     * @inheritDoc
     */
    public function renderCallStackItem($file, $line, $class, $method, $args, $index): string
    {
        try {
            $templateInfo = Template::resolveTemplatePathAndLine($file ?? '', $line);
            if ($templateInfo !== false) {
                [$file, $line] = $templateInfo;
            }
        } catch (SecurityError $e) {
            $line = $e->getTemplateLine();
            $file = $e->getSourceContext()->getPath() ?: null;
        } catch (Throwable $e) {
            // That's fine
        }

        // Call the grandparent ErrorHandler::renderCallStackItem() so Craft's ErrorHandler::renderCallStackItem()
        // doesn't throw an additional exception when trying to render the callstack
        $reflectionMethod = new ReflectionMethod(get_parent_class(get_parent_class($this)), 'renderCallStackItem');

        return $reflectionMethod->invokeArgs($this, [$file, $line, $class, $method, $args, $index]);
    }
}

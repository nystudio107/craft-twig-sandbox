<?php

namespace nystudio107\crafttwigsandbox\web;

use Craft;
use craft\web\twig\Environment;
use craft\web\View;
use nystudio107\closure\Closure;
use nystudio107\crafttwigsandbox\console\SandboxErrorHandler as ConsoleSandboxErrorHandler;
use nystudio107\crafttwigsandbox\twig\BlacklistSecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxErrorHandler as WebSandboxErrorHandler;
use Twig\Extension\SandboxExtension;
use Twig\Sandbox\SecurityPolicyInterface;

class SandboxView extends View
{
    // Public Properties
    // =========================================================================

    /**
     * @var SecurityPolicyInterface|null The security policy to use for the SandboxView
     */
    public ?SecurityPolicyInterface $securityPolicy = null;

    // Protected Properties
    // =========================================================================

    /**
     * @var WebSandboxErrorHandler|ConsoleSandboxErrorHandler|null The error handler to use for the SandboxView
     */
    protected WebSandboxErrorHandler|ConsoleSandboxErrorHandler|null $sandboxErrorHandler = null;

    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        $this->sandboxErrorHandler = Craft::$app->getRequest()->getIsConsoleRequest() ? new ConsoleSandboxErrorHandler() : new WebSandboxErrorHandler();
        // Use the passed in SecurityPolicy, or create a default security policy
        $this->securityPolicy = $this->securityPolicy ?? new BlacklistSecurityPolicy();
    }

    /**
     * @inheritDoc
     */
    public function createTwig(): Environment
    {
        $twig = parent::createTwig();
        // Add the SandboxExtension with our SecurityPolicy after Twig is created
        $twig->addExtension(new SandboxExtension($this->securityPolicy, true));
        // Support Craft Closure
        if (Craft::$app->hasModule('closure')) {
            // Add it to our Twig sandbox
            Closure::getInstance()?->addClosure($twig);
        }

        return $twig;
    }

    /**
     * @inheritDoc
     */
    public function renderObjectTemplate(string $template, mixed $object, array $variables = [], string $templateMode = self::TEMPLATE_MODE_SITE): string
    {
        $result = '';
        try {
            $result = parent::renderObjectTemplate($template, $object, $variables, $templateMode);
        } catch (\Throwable $e) {
            $this->sandboxErrorHandler->handleException($e);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function renderString(string $template, array $variables = [], string $templateMode = self::TEMPLATE_MODE_SITE, bool $escapeHtml = false): string
    {
        $result = '';
        try {
            $result = parent::renderString($template, $variables, $templateMode, $escapeHtml);
        } catch (\Throwable $e) {
            $this->sandboxErrorHandler->handleException($e);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function renderTemplate(string $template, array $variables = [], ?string $templateMode = null): string
    {
        $result = '';
        try {
            $result = parent::renderTemplate($template, $variables, $templateMode);
        } catch (\Throwable $e) {
            $this->sandboxErrorHandler->handleException($e);
        }

        return $result;
    }
}

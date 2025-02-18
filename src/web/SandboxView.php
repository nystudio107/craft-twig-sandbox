<?php

namespace nystudio107\crafttwigsandbox\web;

use Craft;
use craft\web\View;
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

    /**
     * @var WebSandboxErrorHandler|ConsoleSandboxErrorHandler|null The error handler to use for the SandboxView
     */
    public WebSandboxErrorHandler|ConsoleSandboxErrorHandler|null $sandboxErrorHandler = null;

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
        // Add the SandboxExtension with our SecurityPolicy lazily via ::registerTwigExtension()
        $this->registerTwigExtension(new SandboxExtension($this->securityPolicy, true));
    }
}

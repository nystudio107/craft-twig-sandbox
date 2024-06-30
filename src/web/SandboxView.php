<?php

namespace nystudio107\crafttwigsandbox\web;

use craft\web\ErrorHandler;
use craft\web\twig\Environment;
use craft\web\View;
use modules\sitemodule\twig\AllowedSecurityPolicy;
use Twig\Extension\SandboxExtension;
use Twig\Sandbox\SecurityPolicyInterface;

class SandboxView extends View
{
    /**
     * @var SecurityPolicyInterface|null The security policy to use for the SandboxView
     */
    public ?SecurityPolicyInterface $securityPolicy = null;

    /**
     * @var ErrorHandler|null The error handler to use for the SandboxView
     */
    public ?ErrorHandler $sandboxErrorHandler = null;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        // Use the passed in ErrorHandler, or create a default error handler
        $this->sandboxErrorHandler = $this->sandboxErrorHandler ?? new SandboxErrorHandler();
        // Use the passed in SecurityPolicy, or create a default security policy
        $this->securityPolicy = $this->securityPolicy ?? new AllowedSecurityPolicy();
    }

    /**
     * @inheritDoc
     */
    public function createTwig(): Environment
    {
        $twig = parent::createTwig();
        // Add the SandboxExtension with our SecurityPolicy after Twig is created
        $twig->addExtension(new SandboxExtension($this->securityPolicy, true));
        $this->sandboxErrorHandler->env = $twig;

        return $twig;
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
}

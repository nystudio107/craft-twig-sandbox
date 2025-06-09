<?php

namespace nystudio107\crafttwigsandbox\twig;

use nystudio107\crafttwigsandbox\helpers\SecurityPolicy;
use Twig\Markup;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Template;

class BlacklistSecurityPolicy extends BaseSecurityPolicy
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function __construct($config = [])
    {
        if (empty($config)) {
            $config = SecurityPolicy::getConfigFromFile('blacklist-sandbox', '@vendor/nystudio107/craft-twig-sandbox/src/config');
            unset($config['class']);
        }
        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function checkSecurity($tags, $filters, $functions): void
    {
        foreach ($tags as $tag) {
            if (in_array($tag, $this->getTwigTags(), true)) {
                throw new SecurityNotAllowedTagError(sprintf('Tag "%s" is not allowed.', $tag), $tag);
            }
        }

        foreach ($filters as $filter) {
            if (in_array($filter, $this->getTwigFilters(), true)) {
                throw new SecurityNotAllowedFilterError(sprintf('Filter "%s" is not allowed.', $filter), $filter);
            }
        }

        foreach ($functions as $function) {
            if (in_array($function, $this->getTwigFunctions(), true)) {
                throw new SecurityNotAllowedFunctionError(sprintf('Function "%s" is not allowed.', $function), $function);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function checkMethodAllowed($obj, $method): void
    {
        if ($obj instanceof Template || $obj instanceof Markup) {
            return;
        }

        $method = strtolower($method);
        $allowed = true;
        foreach ($this->getTwigMethods() as $class => $methods) {
            if ($obj instanceof $class) {
                if ($methods[0] === '*' || in_array($method, $methods, true)) {
                    $allowed = false;
                    break;
                }
            }
        }

        if (!$allowed) {
            $class = \get_class($obj);
            throw new SecurityNotAllowedMethodError(sprintf('Calling "%s" method on a "%s" object is not allowed.', $method, $class), $class, $method);
        }
    }

    /**
     * @inheritDoc
     */
    public function checkPropertyAllowed($obj, $property): void
    {
        $allowed = true;
        $property = strtolower($property);
        foreach ($this->getTwigProperties() as $class => $properties) {
            if ($obj instanceof $class) {
                if ($properties[0] === '*' || in_array($property, $properties, true)) {
                    $allowed = false;
                    break;
                }
            }
        }

        if (!$allowed) {
            $class = \get_class($obj);
            throw new SecurityNotAllowedPropertyError(sprintf('Accessing "%s" property on a "%s" object is not allowed.', $property, $class), $class, $property);
        }
    }
}

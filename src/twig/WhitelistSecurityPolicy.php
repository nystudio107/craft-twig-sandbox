<?php

namespace nystudio107\crafttwigsandbox\twig;

use Twig\Markup;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Template;

class WhitelistSecurityPolicy extends BaseSecurityPolicy
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function __construct($config = [])
    {
        // Whitelisted tags
        $this->setTwigTags([
            'for',
            'if',
            'set',
        ]);
        // Whitelisted filters
        $this->setTwigFilters([
            'capitalize',
            'date',
            'escape',
            'first',
            'join',
            'keys',
            'last',
            'length',
            'lower',
            'markdown',
            'nl2br',
            'number_format',
            'raw',
            'replace',
            'sort',
            'split',
            'striptags',
            'title',
            'trim',
            'upper',
            'camel',
            'contains',
            'currency',
            'date',
            'datetime',
            'id',
            'index',
            'indexOf',
            'kebab',
            'lcfirst',
            'length',
            'markdown',
            'md',
            'merge',
            'money',
            'pascal',
            'percentage',
            'purify',
            'snake',
            'time',
            'timestamp',
            'translate',
            't',
            'ucfirst',
            'ucwords',
        ]);
        // Whitelisted functions
        $this->setTwigFunctions([
            'date',
            'max',
            'min',
            'random',
            'range',
            'collect',
        ]);

        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function checkSecurity($tags, $filters, $functions): void
    {
        foreach ($tags as $tag) {
            if (!in_array($tag, $this->getTwigTags(), true)) {
                throw new SecurityNotAllowedTagError(sprintf('Tag "%s" is not allowed.', $tag), $tag);
            }
        }

        foreach ($filters as $filter) {
            if (!in_array($filter, $this->getTwigFilters(), true)) {
                throw new SecurityNotAllowedFilterError(sprintf('Filter "%s" is not allowed.', $filter), $filter);
            }
        }

        foreach ($functions as $function) {
            if (!in_array($function, $this->getTwigFunctions(), true)) {
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

        $method = strtr($method, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
        $allowed = false;
        foreach ($this->getTwigMethods() as $class => $methods) {
            if ($obj instanceof $class && \in_array($method, $methods)) {
                $allowed = true;
                break;
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
        $allowed = false;
        foreach ($this->getTwigProperties() as $class => $properties) {
            if ($obj instanceof $class && \in_array($property, \is_array($properties) ? $properties : [$properties])) {
                $allowed = true;
                break;
            }
        }

        if (!$allowed) {
            $class = \get_class($obj);
            throw new SecurityNotAllowedPropertyError(sprintf('Accessing "%s" property on a "%s" object is not allowed.', $property, $class), $class, $property);
        }
    }
}

<?php

namespace nystudio107\crafttwigsandbox\twig;

use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTagError;

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
        // Allow all methods
    }

    /**
     * @inheritDoc
     */
    public function checkPropertyAllowed($obj, $property): void
    {
        // Allow all properties
    }
}

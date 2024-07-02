<?php

namespace nystudio107\crafttwigsandbox\twig;

use craft\base\Model;
use Twig\Sandbox\SecurityPolicyInterface;

/**
 * @property array|string[] $twigTags  Tags for the Twig sandbox Security Policy
 * @property array|string[] $twigFilters  Filters for the Twig sandbox Security Policy
 * @property array|string[] $twigFunctions  Functions for the Twig sandbox Security Policy
 * @property array|string[] $twigMethods  Object methods for the Twig sandbox Security Policy
 * @property array|string[] $twigProperties  Object properties for the Twig sandbox Security Policy
 */
abstract class BaseSecurityPolicy extends Model implements SecurityPolicyInterface
{
    // Private Properties
    // =========================================================================

    /**
     * @var array|string[] Tags for the Twig sandbox Security Policy
     */
    private array $twigTags = [
    ];

    /**
     * @var array|string[] Filters for the Twig sandbox Security Policy
     */
    private array $twigFilters = [
    ];

    /**
     * @var array|string[] Functions for the Twig sandbox Security Policy
     */
    private array $twigFunctions = [
    ];

    /**
     * @var array|string[] Object methods for the Twig sandbox Security Policy
     */
    private array $twigMethods = [
    ];

    /**
     * @var array|string[] Object properties for the Twig sandbox Security Policy
     */
    private array $twigProperties = [
    ];

    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function checkSecurity($tags, $filters, $functions): void
    {
        // Allow all tags, filters, and functions
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

    // Getters & setters
    // =========================================================================

    public function getTwigTags(): array
    {
        return $this->twigTags;
    }

    public function setTwigTags(array $tags): void
    {
        $this->twigTags = $tags;
    }

    public function getTwigFilters(): array
    {
        return $this->twigFilters;
    }

    public function setTwigFilters(array $filters): void
    {
        $this->twigFilters = $filters;
    }

    public function getTwigFunctions(): array
    {
        return $this->twigFunctions;
    }

    public function setTwigFunctions(array $functions): void
    {
        $this->twigFunctions = $functions;
    }

    public function getTwigMethods(): array
    {
        return $this->twigMethods;
    }

    public function setTwigMethods(array $methods): void
    {
        $this->twigMethods = [];
        foreach ($methods as $class => $m) {
            $this->twigMethods[$class] = array_map(static function($value) {
                return strtr($value, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
            }, is_array($m) ? $m : [$m]);
        }
    }

    public function getTwigProperties(): array
    {
        return $this->twigProperties;
    }

    public function setTwigProperties(array $properties): void
    {
        $this->twigProperties = $properties;
    }
}

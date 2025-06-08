<?php

namespace nystudio107\crafttwigsandbox\twig;

use craft\base\Model;
use Twig\Sandbox\SecurityPolicyInterface;

/**
 * @property string[] $twigTags  Tags for the Twig sandbox Security Policy
 * @property string[] $twigFilters  Filters for the Twig sandbox Security Policy
 * @property string[] $twigFunctions  Functions for the Twig sandbox Security Policy
 * @property array[] $twigMethods  Object methods for the Twig sandbox Security Policy
 * @property array[] $twigProperties  Object properties for the Twig sandbox Security Policy
 */
abstract class BaseSecurityPolicy extends Model implements SecurityPolicyInterface
{
    // Private Properties
    // =========================================================================

    /**
     * @var string[] Tags for the Twig sandbox Security Policy
     */
    private array $twigTags = [
    ];

    /**
     * @var string[] Filters for the Twig sandbox Security Policy
     */
    private array $twigFilters = [
    ];

    /**
     * @var string[] Functions for the Twig sandbox Security Policy
     */
    private array $twigFunctions = [
    ];

    /**
     * @var array[] Object methods for the Twig sandbox Security Policy
     */
    private array $twigMethods = [
    ];

    /**
     * @var array[] Object properties for the Twig sandbox Security Policy
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
                return strtolower($value);
            }, is_array($m) ? $m : [$m]);
        }
    }


    public function getTwigProperties(): array
    {
        return $this->twigProperties;
    }

    public function setTwigProperties(array $properties): void
    {
        $this->twigProperties = [];
        foreach ($properties as $class => $p) {
            $this->twigProperties[$class] = array_map(static function($value) {
                return strtolower($value);
            }, is_array($p) ? $p : [$p]);
        }
    }
}

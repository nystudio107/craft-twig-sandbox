<?php

namespace nystudio107\crafttwigsandbox\helpers;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\StringHelper;
use nystudio107\crafttwigsandbox\twig\BaseSecurityPolicy;
use nystudio107\crafttwigsandbox\twig\BlacklistSecurityPolicy;
use nystudio107\seomatic\Seomatic;
use function is_array;

class SandboxConfig
{
    // Static Methods
    // =========================================================================

    public static function sandboxFromFile(string $filePath, ?string $alias = null): BaseSecurityPolicy
    {
        $config = self::getConfigFromFile($filePath, $alias);

        $policyClass = $config['securityPolicy'] ?? BlacklistSecurityPolicy::class;
        $policy = new $policyClass();
        // twigTags
        if (isset($config['twigTags'])) {
            if (isset($config['twigTags']['add'])) {
                $policy->addTwigTags($config['twigTags']['add']);
            }
            if (isset($config['twigTags']['remove'])) {
                $policy->removeTwigTags($config['twigTags']['remove']);
            }
        }
        // twigFilters
        if (isset($config['twigFilters'])) {
            if (isset($config['twigFilters']['add'])) {
                $policy->addTwigFilters($config['twigFilters']['add']);
            }
            if (isset($config['twigFilters']['remove'])) {
                $policy->removeTwigFilters($config['twigFilters']['remove']);
            }
        }
        // twigFunctions
        if (isset($config['twigFunctions'])) {
            if (isset($config['twigFunctions']['add'])) {
                $policy->addTwigFunctions($config['twigFunctions']['add']);
            }
            if (isset($config['twigFunctions']['remove'])) {
                $policy->removeTwigFunctions($config['twigFunctions']['remove']);
            }
        }
        // twigMethods
        if (isset($config['twigMethods'])) {
            if (isset($config['twigMethods']['add'])) {
                $policy->addTwigMethods($config['twigMethods']['add']);
            }
            if (isset($config['twigMethods']['remove'])) {
                $policy->removeTwigMethods($config['twigMethods']['remove']);
            }
        }
        // twigProperties
        if (isset($config['twigProperties'])) {
            if (isset($config['twigProperties']['add'])) {
                $policy->addTwigProperties($config['twigProperties']['add']);
            }
            if (isset($config['twigProperties']['remove'])) {
                $policy->removeTwigProperties($config['twigProperties']['remove']);
            }
        }

        return $policy;
    }

    /**
     * Loads a config file from, trying @craft/config first, then falling back on
     * the provided $alias, if any
     *
     * @param string $filePath
     * @param string|null $alias
     *
     * @return array
     */
    public static function getConfigFromFile(string $filePath, ?string $alias = null): array
    {
        // Try craft/config first
        $path = self::getConfigFilePath('@config', $filePath);
        if (!file_exists($path)) {
            if (!$alias) {
                return [];
            }
            // Now the additional alias config
            $path = self::getConfigFilePath($alias, $filePath);
            if (!file_exists($path)) {
                return [];
            }
        }

        if (!is_array($config = @include $path)) {
            return [];
        }

        // If it's not a multi-environment config, return the whole thing
        if (!array_key_exists('*', $config)) {
            return $config;
        }

        $mergedConfig = [];
        /** @var array $config */
        foreach ($config as $env => $envConfig) {
            if ($env === '*' || StringHelper::contains(Seomatic::$environment, $env)) {
                $mergedConfig = ArrayHelper::merge($mergedConfig, $envConfig);
            }
        }

        return $mergedConfig;
    }

    // Private Methods
    // =========================================================================

    /**
     * Return a path from an alias and a partial path
     *
     * @param string $alias
     * @param string $filePath
     *
     * @return string
     */
    private static function getConfigFilePath(string $alias, string $filePath): string
    {
        $path = DIRECTORY_SEPARATOR . ltrim($filePath, DIRECTORY_SEPARATOR);
        $path = Craft::getAlias($alias)
            . DIRECTORY_SEPARATOR
            . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path)
            . '.php';

        return $path;
    }
}

<?php

namespace nystudio107\crafttwigsandbox\helpers;

use Craft;
use craft\helpers\ArrayHelper;
use nystudio107\crafttwigsandbox\twig\BaseSecurityPolicy;
use function is_array;

class SecurityPolicy
{
    // Static Methods
    // =========================================================================

    public static function createFromFile(string $filePath, ?string $alias = null): BaseSecurityPolicy
    {
        $config = self::getConfigFromFile($filePath, $alias);

        return Craft::createObject($config);
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
            if ($env === '*') {
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

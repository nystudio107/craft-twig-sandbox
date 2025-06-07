<?php

/**
 * Sandbox config.php
 *
 * This file exists only as a template for a sandbox configuration.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'xxxx-sandbox.php'
 * and make your changes there to override default settings.
 *
 * The idea is that this allows for a user-editable config file so that users
 * can customize the Twig sandbox that your application uses.
 */

use nystudio107\crafttwigsandbox\twig\BlacklistSecurityPolicy;

return [
    'securityPolicy' => BlacklistSecurityPolicy::class,
    'twigTags' => [
        'add' => [],
        'remove' => [],
    ],
    'twigFilters' => [
        'add' => [],
        'remove' => [],
    ],
    'twigFunctions' => [
        'add' => [],
        'remove' => [],
    ],
    'twigMethods' => [
        'add' => [],
        'remove' => [],
    ],
    'twigProperties' => [
        'add' => [],
        'remove' => [],
    ],
];

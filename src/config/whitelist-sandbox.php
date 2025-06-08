<?php

/**
 * SecurityPolicy config.php
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

use nystudio107\crafttwigsandbox\twig\WhitelistSecurityPolicy;

return [
    'class' => WhitelistSecurityPolicy::class,
    'twigTags' => [
        'for',
        'if',
        'set',
    ],
    'twigFilters' => [
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
    ],
    'twigFunctions' => [
        'date',
        'max',
        'min',
        'random',
        'range',
        'collect',
    ],
    'twigMethods' => [
    ],
    'twigProperties' => [
    ],
];

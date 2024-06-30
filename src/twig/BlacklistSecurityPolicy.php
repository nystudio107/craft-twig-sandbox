<?php

namespace nystudio107\crafttwigsandbox\twig;

use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTagError;

class BlacklistSecurityPolicy extends BaseSecurityPolicy
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function __construct($config = [])
    {
        // Blacklisted tags
        $this->setTwigTags([
            'apply',
            'autoescape',
            'block',
            'deprecated',
            'do',
            'embed',
            'extends',
            'flush',
            'from',
            'import',
            'include',
            'macro',
            'sandbox',
            'use',
            'verbatim',
            'with',
            'cache',
            'css',
            'dd',
            'dump',
            'exit',
            'header',
            'hook',
            'html',
            'js',
            'namespace',
            'nav',
            'paginate',
            'redirect',
            'requireAdmin',
            'requireEdition',
            'requireGuest',
            'requireLogin',
            'requirePermission',
            'script',
            'switch',
            'tag',
        ]);
        // Blacklisted filters
        $this->setTwigFilters([
            'abs',
            'batch',
            'column',
            'convert_encoding',
            'country_name',
            'country_timezones',
            'currency_name',
            'currency_symbol',
            'data_uri',
            'date_modify',
            'default',
            'filter',
            'format',
            'format_currency',
            'format_date',
            'format_datetime',
            'format_number',
            'format_time',
            'inky',
            'inline_css',
            'json_encode',
            'language_name',
            'locale_name',
            'map',
            'merge',
            'reduce',
            'reverse',
            'round',
            'slice',
            'spaceless',
            'timezone_name',
            'url_encode',
            'address',
            'append',
            'ascii',
            'atom',
            'attr',
            'base64_decode',
            'base64_encode',
            'boolean',
            'column',
            'diff',
            'duration',
            'encenc',
            'explodeClass',
            'explodeStyle',
            'filesize',
            'filter',
            'float',
            'group',
            'hash',
            'httpdate',
            'integer',
            'intersect',
            'json_encode',
            'json_decode',
            'literal',
            'multisort',
            'namespace',
            'ns',
            'namespaceAttributes',
            'namespaceInputId',
            'namespaceInputName',
            'number',
            'parseAttr',
            'parseRefs',
            'prepend',
            'push',
            'removeClass',
            'rss',
            'string',
            'truncate',
            'unique',
            'unshift',
            'values',
            'where',
            'widont',
            'without',
            'withoutKey',
        ]);
        // Blacklisted functions
        $this->setTwigFunctions([
            'attribute',
            'block',
            'constant',
            'cycle',
            'dump',
            'html_classes',
            'parent',
            'source',
            'template_from_string',
            'actionInput',
            'alias',
            'beginBody',
            'block',
            'canCreateDrafts',
            'canDelete',
            'canDeleteForSite',
            'canDuplicate',
            'canSave',
            'canView',
            'ceil',
            'className',
            'clone',
            'combine',
            'configure',
            'constant',
            'create',
            'csrfInput',
            'dump',
            'endBody',
            'expression',
            'failMessageInput',
            'floor',
            'getenv',
            'gql',
            'head',
            'hiddenInput',
            'input',
            'ol',
            'parseBooleanEnv',
            'parseEnv',
            'plugin',
            'redirectInput',
            'renderObjectTemplate',
            'seq',
            'shuffle',
            'source',
            'successMessageInput',
            'ul',
        ]);

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

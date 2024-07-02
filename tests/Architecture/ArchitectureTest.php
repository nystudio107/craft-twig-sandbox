<?php

/**
 * Tests the architecture of the plugin.
 */

arch('globals')
    ->expect(['var_dump', 'die'])
    ->not->toBeUsed();

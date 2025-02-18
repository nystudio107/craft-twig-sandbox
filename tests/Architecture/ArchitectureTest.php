<?php

/**
 * Tests the architecture of the plugin.
 */

/**
 * When run locally, this test inexplicably fails with:
 * FAILED  Users\andrew\webdev\craftv5\crafttwigsandbox\tests\Architecture\ArchitectureTest > globals                                                              ArgumentCountError
 * Too few arguments to function Closure::arch(), 0 passed in /var/www/project/cms_v5/vendor/pestphp/pest/src/Support/Reflection.php on line 59 and at least 1 expected
 *
 * So it is commented out for now
 *
 * arch('globals')
 * ->expect(['var_dump', 'die', 'Craft::dd'])
 * ->not->toBeUsed();
 */

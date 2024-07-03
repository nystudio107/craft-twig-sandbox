# Testing

## Pest Tests

The tests are run automatically via the `code-analysis.yaml` GitHub Action workflow.

To run them manually in a local development environment where the plugin is installed in a "host" Craft development environment, do the following:

```shell
php vendor/bin/pest --configuration=vendor/nystudio107/craft-twig-sandbox/phpunit.xml --test-directory=vendor/nystudio107/craft-twig-sandbox/tests
```

#!/bin/bash
./vendor/bin/phpunit --list-tests-xml=tests/fixtures/tests.xml tests/fixtures/src
./vendor/bin/phpunit tests/fixtures/src --exclude-group slow --cache-result --cache-result-file=tests/fixtures/.phpunit.cache/test-results-1.json
./vendor/bin/phpunit tests/fixtures/src --group slow --cache-result --cache-result-file=tests/fixtures/.phpunit.cache/test-results-2.json

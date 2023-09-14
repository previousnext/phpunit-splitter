#!/bin/bash
./vendor/bin/phpunit --list-tests-xml=tests/fixtures/tests.xml tests/fixtures/Test
./vendor/bin/phpunit tests/fixtures/Test --cache-result --cache-result-file=tests/fixtures/.phpunit.result.cache

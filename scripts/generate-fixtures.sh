#!/bin/bash
./vendor/bin/phpunit --list-tests-xml=tests/fixtures/tests.xml tests/fixtures/src
./vendor/bin/phpunit tests/fixtures/src --cache-result --cache-result-file=tests/fixtures/.phpunit.result.cache

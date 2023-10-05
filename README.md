# PHPUnit Test Splitter

Allows you to split your PHPUnit tests by timings.

## Usage

Generate a timing file:

```bash
phpunit --cache-result --cache-result-file=.phpunit.result.cache
```

List your tests:

```bash
phpunit --list-tests-xml=tests.xml 
```

This generates an XML file with a list of tests. You can add `--testsuite` to limit the tests to a specific suite.

Split the tests in 2 groups and get the first group (0):

```bash
phpunit-splitter 2 0 --tests-file=tests.xml --results-file=.phpunit.result.cache
```

Split the tests in 4 groups and get the third group (2):

```bash
phpunit-splitter 4 2 --tests-file=tests.xml --results-file=.phpunit.result.cache
```

Pass the results to PHPUnit:

```bash
./phpunit-splitter 2 0 --tests-file=tests/fixtures/tests.xml --results-file=tests/fixtures/.phpunit.result.cache | xargs ./vendor/bin/phpunit 
done
```

Output the test list as JSON:

```bash
./phpunit-splitter 2 0 --json --tests-file=tests/fixtures/tests.xml --results-file=tests/fixtures/.phpunit.result.cache
```

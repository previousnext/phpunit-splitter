<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use PhpUnitSplitter\TestMapper;

/**
 * Tests for the TestMapper class.
 */
#[CoversClass(TestMapper::class)]
class PhpUnitSplitterTest extends TestCase {

  #[Test]
  public function testSplitter(): void {
    $fixtures = \dirname(__DIR__) . '/fixtures';
    $mapper = new TestMapper("$fixtures/tests.xml", "$fixtures/.phpunit.cache/*/test-results*", \dirname(__DIR__, 2) . '/');
    $map = $mapper->getMap();

    $this->assertSame([
      'tests/fixtures/src/FastTestsTest.php',
      'tests/fixtures/src/ProviderTest.php',
      'tests/fixtures/src/SlowTestsTest.php',
    ], \array_keys($map));

    $sorted = $mapper->sortMap($map);
    $this->assertSame([
      'tests/fixtures/src/FastTestsTest.php',
      'tests/fixtures/src/SlowTestsTest.php',
      'tests/fixtures/src/ProviderTest.php',
    ], \array_keys($sorted));
  }

}

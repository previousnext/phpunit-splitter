<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests;

use PHPUnit\Framework\TestCase;
use PhpUnitSplitter\TestMapper;

/**
 * @coversDefaultClass \PhpUnitSplitter\TestMapper
 */
class PhpUnitSplitterTest extends TestCase {

  /**
   * @covers ::getMap
   */
  public function testSplitter(): void {
    $fixtures = \dirname(__DIR__) . '/fixtures';
    $mapper = new TestMapper("$fixtures/tests.xml", "$fixtures/.phpunit.result.cache", \dirname(__DIR__, 2) . '/');
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

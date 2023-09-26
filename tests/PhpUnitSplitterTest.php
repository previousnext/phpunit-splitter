<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests;

use PHPUnit\Framework\TestCase;
use PhpUnitSplitter\TestMapper;

class PhpUnitSplitterTest extends TestCase {

  public function testSplitter(): void {
    $fixtures = dirname(__DIR__) . '/tests/fixtures';
    $mapper = new TestMapper("$fixtures/tests.xml", "$fixtures/.phpunit.result.cache", \getcwd() . '/');
    $map = $mapper->getMap();

    $this->assertSame([
      'fixtures/Test/FastTestsTest.php',
      'fixtures/Test/ProviderTest.php',
      'fixtures/Test/SlowTestsTest.php',
    ], array_keys($map));

    $sorted = $mapper->sortMap($map);
    $this->assertSame([
      'fixtures/Test/FastTestsTest.php',
      'fixtures/Test/SlowTestsTest.php',
      'fixtures/Test/ProviderTest.php',
    ], array_keys($sorted));

  }
}

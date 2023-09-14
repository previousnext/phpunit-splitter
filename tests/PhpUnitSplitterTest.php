<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests;

use PHPUnit\Framework\TestCase;
use PhpUnitSplitter\TestMapper;

class PhpUnitSplitterTest extends TestCase {

  public function testSplitter(): void {
    $fixtures = dirname(__DIR__) . '/tests/fixtures';
    $mapper = new TestMapper("$fixtures/tests.xml", "$fixtures/.phpunit.result.cache");
    $map = $mapper->getMap();

    $this->assertSame([
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\FastTestsTest::testOne',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\FastTestsTest::testTwo',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\FastTestsTest::testThree',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\FastTestsTest::testFour',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\FastTestsTest::testFive',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\ProviderTest::testProvider with data set "one"',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\ProviderTest::testProvider with data set "two"',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\ProviderTest::testProvider with data set "three"',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\ProviderTest::testProvider with data set "four"',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\ProviderTest::testProvider with data set "five"',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\SlowTestsTest::testOne',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\SlowTestsTest::testTwo',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\SlowTestsTest::testThree',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\SlowTestsTest::testFour',
      'PhpUnitSplitter\\Tests\\fixtures\\Test\\SlowTestsTest::testFive',
    ], array_keys($map));

    $sorted = $mapper->sortMap($map);
    $this->assertSame([
      'PhpUnitSplitter\Tests\fixtures\Test\FastTestsTest::testOne',
      'PhpUnitSplitter\Tests\fixtures\Test\FastTestsTest::testTwo',
      'PhpUnitSplitter\Tests\fixtures\Test\FastTestsTest::testThree',
      'PhpUnitSplitter\Tests\fixtures\Test\FastTestsTest::testFour',
      'PhpUnitSplitter\Tests\fixtures\Test\FastTestsTest::testFive',
      'PhpUnitSplitter\Tests\fixtures\Test\SlowTestsTest::testOne',
      'PhpUnitSplitter\Tests\fixtures\Test\ProviderTest::testProvider with data set "one"',
      'PhpUnitSplitter\Tests\fixtures\Test\SlowTestsTest::testTwo',
      'PhpUnitSplitter\Tests\fixtures\Test\ProviderTest::testProvider with data set "three"',
      'PhpUnitSplitter\Tests\fixtures\Test\SlowTestsTest::testThree',
      'PhpUnitSplitter\Tests\fixtures\Test\ProviderTest::testProvider with data set "four"',
      'PhpUnitSplitter\Tests\fixtures\Test\SlowTestsTest::testFour',
      'PhpUnitSplitter\Tests\fixtures\Test\ProviderTest::testProvider with data set "two"',
      'PhpUnitSplitter\Tests\fixtures\Test\SlowTestsTest::testFive',
      'PhpUnitSplitter\Tests\fixtures\Test\ProviderTest::testProvider with data set "five"',
    ], array_keys($sorted));

  }
}

<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests;

use PHPUnit\Framework\TestCase;
use PhpUnitSplitter\GlobbingTestResultCache;

/**
 * @coversDefaultClass \PhpUnitSplitter\GlobbingTestResultCache
 */
class GlobbingTestResultCacheTest extends TestCase {

  /**
   * @covers ::load
   */
  public function testLoadFile(): void {
    $cache = new GlobbingTestResultCache(\dirname(__DIR__) . '/fixtures/.phpunit.cache/test-results*');
    $cache->load();
    // Assert we get test times for both cache files.
    $this->assertEquals(0.011, $cache->getTime('PhpUnitSplitter\Tests\Fixtures\FastTestsTest::testOne'));
    $this->assertEquals(0.101, $cache->getTime('PhpUnitSplitter\Tests\Fixtures\SlowTestsTest::testOne'));
  }

}

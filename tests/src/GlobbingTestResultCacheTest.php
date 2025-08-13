<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use PhpUnitSplitter\GlobbingTestResultCache;

/**
 * Tests for the GlobbingTestResultCache class.
 */
#[CoversClass(GlobbingTestResultCache::class)]
class GlobbingTestResultCacheTest extends TestCase {

    /**
     * Tests loading multiple cache files.
     */
    #[Test]
    public function testLoadFile(): void {
    $cache = new GlobbingTestResultCache(\dirname(__DIR__) . '/fixtures/.phpunit.cache/*/test-results*');
    $cache->load();
    // Assert we get test times for both cache files.
    $this->assertEquals(0.011, $cache->getTime('PhpUnitSplitter\Tests\Fixtures\FastTestsTest::testOne'));
    $this->assertEquals(0.101, $cache->getTime('PhpUnitSplitter\Tests\Fixtures\SlowTestsTest::testOne'));
  }

}

<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Simulates a slow test.
 *
 * @group slow
 */
class SlowTestsTest extends TestCase {

  /**
   * @covers ::testOne
   */
  public function testOne(): void {
    \usleep(100000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testTwo
   */
  public function testTwo(): void {
    \usleep(200000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testThree
   */
  public function testThree(): void {
    \usleep(300000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testFour
   */
  public function testFour(): void {
    \usleep(400000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testFive
   */
  public function testFive(): void {
    \usleep(500000);
    $this->assertTrue(TRUE);
  }

}

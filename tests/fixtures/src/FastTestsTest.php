<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Simulates a fast test.
 */
class FastTestsTest extends TestCase {

  /**
   * @covers ::testOne
   */
  public function testOne(): void {
    \usleep(10000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testTwo
   */
  public function testTwo(): void {
    \usleep(20000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testThree
   */
  public function testThree(): void {
    \usleep(30000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testFour
   */
  public function testFour(): void {
    \usleep(40000);
    $this->assertTrue(TRUE);
  }

  /**
   * @covers ::testFive
   */
  public function testFive(): void {
    \usleep(50000);
    $this->assertTrue(TRUE);
  }

}

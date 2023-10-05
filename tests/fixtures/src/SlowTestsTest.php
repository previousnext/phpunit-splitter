<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Simulates a slow test.
 */
class SlowTestsTest extends TestCase {

  /**
   *
   */
  public function testOne(): void {
    \usleep(100000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testTwo(): void {
    \usleep(200000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testThree(): void {
    \usleep(300000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testFour(): void {
    \usleep(400000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testFive(): void {
    \usleep(500000);
    $this->assertTrue(TRUE);
  }

}

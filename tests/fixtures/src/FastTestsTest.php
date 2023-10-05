<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Simulates a fast test.
 */
class FastTestsTest extends TestCase {

  /**
   *
   */
  public function testOne(): void {
    \usleep(10000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testTwo(): void {
    \usleep(20000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testThree(): void {
    \usleep(30000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testFour(): void {
    \usleep(40000);
    $this->assertTrue(TRUE);
  }

  /**
   *
   */
  public function testFive(): void {
    \usleep(50000);
    $this->assertTrue(TRUE);
  }

}

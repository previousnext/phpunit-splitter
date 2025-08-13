<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Simulates a fast test.
 */
#[CoversNothing]
class FastTestsTest extends TestCase {

  #[Test]
  public function testOne(): void {
    \usleep(10000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testTwo(): void {
    \usleep(20000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testThree(): void {
    \usleep(30000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testFour(): void {
    \usleep(40000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testFive(): void {
    \usleep(50000);
    $this->assertTrue(TRUE);
  }

}

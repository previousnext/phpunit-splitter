<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Simulates a slow test.
 */
#[CoversNothing]
#[Group('slow')]
class SlowTestsTest extends TestCase {

  #[Test]
  public function testOne(): void {
    \usleep(100000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testTwo(): void {
    \usleep(200000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testThree(): void {
    \usleep(300000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testFour(): void {
    \usleep(400000);
    $this->assertTrue(TRUE);
  }

  #[Test]
  public function testFive(): void {
    \usleep(500000);
    $this->assertTrue(TRUE);
  }

}

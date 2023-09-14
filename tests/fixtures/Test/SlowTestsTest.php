<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests\fixtures\Test;

use PHPUnit\Framework\TestCase;

class SlowTestsTest extends TestCase {

  function testOne(): void {
    usleep(100000);
    $this->assertTrue(TRUE);
  }

  function testTwo(): void {
    usleep(200000);
    $this->assertTrue(TRUE);
  }

  function testThree(): void {
    usleep(300000);
    $this->assertTrue(TRUE);
  }

  function testFour(): void {
    usleep(400000);
    $this->assertTrue(TRUE);
  }

  function testFive(): void {
    usleep(500000);
    $this->assertTrue(TRUE);
  }

}

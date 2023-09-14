<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests\fixtures\Test;

use PHPUnit\Framework\TestCase;

class FastTestsTest extends TestCase {

  function testOne(): void {
    usleep(10000);
    $this->assertTrue(TRUE);
  }

  function testTwo(): void {
    usleep(20000);
    $this->assertTrue(TRUE);
  }

  function testThree(): void {
    usleep(30000);
    $this->assertTrue(TRUE);
  }

  function testFour(): void {
    usleep(40000);
    $this->assertTrue(TRUE);
  }

  function testFive(): void {
    usleep(50000);
    $this->assertTrue(TRUE);
  }

}

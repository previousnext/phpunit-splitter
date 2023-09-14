<?php

declare(strict_types=1);

namespace PhpUnitSplitter\Tests\fixtures\Test;

use PHPUnit\Framework\TestCase;

class ProviderTest extends TestCase {

  /**
   * @dataProvider provider
   */
  function testProvider(int $sleep): void {
    usleep($sleep);
    $this->assertTrue(TRUE);
  }

  public function provider(): array {
    return [
      'one' => [111111],
      'two' => [444444],
      'three' => [222222],
      'four' => [333333],
      'five' => [666666],
    ];
  }


}

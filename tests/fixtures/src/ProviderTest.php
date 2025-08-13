<?php

declare(strict_types = 1);

namespace PhpUnitSplitter\Tests\Fixtures;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Simulates a provider test.
 */
#[CoversNothing]
class ProviderTest extends TestCase {

  #[Test]
  #[DataProvider('provider')]
  public function testProvider(int $sleep): void {
    \usleep($sleep);
    $this->assertTrue(TRUE);
  }

  public static function provider(): array {
    return [
      'one' => [111111],
      'two' => [444444],
      'three' => [222222],
      'four' => [333333],
      'five' => [666666],
    ];
  }

}

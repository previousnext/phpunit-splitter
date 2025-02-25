<?php

declare(strict_types=1);

namespace PhpUnitSplitter;

/**
 * The test status.
 */
enum TestStatus: int {

  case Unknown = -1;
  case Passed = 0;
  case Skipped = 1;
  case Incomplete = 2;
  case Failure = 3;
  case Error = 4;
  case Risky = 5;
  case Warning = 6;

  /**
   * Get the status value.
   */
  public function getValue(): int {
    return $this->value;
  }

}

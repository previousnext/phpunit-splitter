<?php

declare(strict_types = 1);

namespace PhpUnitSplitter;

/**
 * The test status.
 */
enum TestStatus: int {

  case UNKNOWN = -1;
  case PASSED = 0;
  case SKIPPED = 1;
  case INCOMPLETE = 2;
  case FAILURE = 3;
  case ERROR = 4;
  case RISKY = 5;
  case WARNING = 6;

  /**
   * Get the status value.
   */
  public function getValue(): int {
    return $this->value;
  }

}

<?php

declare(strict_types=1);

namespace PhpUnitSplitter;

/**
 * A test result cache that can load multiple files.
 */
final class GlobbingTestResultCache {

  /**
   * @var int
   */
  private const VERSION = 1;

  /**
   * The cache file names.
   *
   * @var array<string>
   */
  private array $cacheFilenames = [];

  /**
   * @var array<string, int>
   */
  private array $defects = [];

  /**
   * @var array<string, float>
   */
  private array $times = [];

  /**
   * Constructs a new GlobbingTestResultCache.
   */
  public function __construct(
    string $filepaths = ".phpunit.cache/test-results*",
  ) {
    $filenames = \glob($filepaths);
    if ($filenames === FALSE) {
      $filenames = [];
    }
    $this->cacheFilenames = $filenames;
  }

  /**
   * {@inheritdoc}
   */
  public function getState(string $testName): int {
    return $this->defects[$testName] ?? TestStatus::UNKNOWN->getValue();
  }

  /**
   * {@inheritdoc}
   */
  public function getTime(string $testName): float {
    return $this->times[$testName] ?? 0.0;
  }

  /**
   * {@inheritdoc}
   */
  public function load(): void {
    foreach ($this->cacheFilenames as $filename) {
      $data = $this->loadFile($filename);
      $this->defects += $data['defects'];
      $this->times += $data['times'];
    }
  }

  /**
   * Loads the data from the given file.
   *
   * @param string $filename
   *   The filename.
   *
   * @return array<string, array<string, int|float>>
   *   The test result data.
   */
  protected function loadFile(string $filename): array {
    if (!\is_file($filename)) {
      return [];
    }

    $data = \json_decode(\file_get_contents($filename), TRUE);

    if ($data === NULL) {
      return [];
    }

    if (!isset($data['version'])) {
      return [];
    }

    if ($data['version'] !== self::VERSION) {
      return [];
    }

    \assert(isset($data['defects']) && \is_array($data['defects']));
    \assert(isset($data['times']) && \is_array($data['times']));

    return $data;
  }

}

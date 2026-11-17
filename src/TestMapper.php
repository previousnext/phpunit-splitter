<?php

declare(strict_types=1);

namespace PhpUnitSplitter;

/**
 * Generates a map of test methods with their file name and execution time.
 *
 * @phpstan-type TestCaseTime array{testCase: string, time: float}
 * @phpstan-type TestClassEntry array{className: string, time: float, testCases: list<TestCaseTime>}
 * @phpstan-type TestMap array<array-key, TestClassEntry>
 */
final class TestMapper {

  private \SimpleXMLElement|false $testsXml;

  private GlobbingTestResultCache $resultCache;

  private string $prefix;

  /**
   * Constructs a new TestMapper.
   */
  public function __construct(
    string $testListFilePath,
    string $testResultFiles,
    string $prefix,
  ) {
    $this->testsXml = \simplexml_load_file($testListFilePath);
    $this->resultCache = new GlobbingTestResultCache($testResultFiles);
    $this->prefix = $prefix;
  }

  /**
   * Returns a map of test methods with their file name and execution time.
   *
   * @return TestMap
   *   The map of test files and execution times.
   */
  public function getMap(): array {
    $this->resultCache->load();
    $map = [];
    $classesXpath = $this->testsXml->xpath('//testCaseClass');
    foreach ($classesXpath as $class) {
      $className = (string) $class->attributes()['name'];
      try {
        $reflection = new \ReflectionClass($className);
      }
      catch (\ReflectionException $e) {
        // Couldn't find the class.
        continue;
      }
      $filename = $reflection->getFileName();
      if (\str_starts_with($filename, $this->prefix)) {
        $filename = \substr($filename, \strlen($this->prefix));
      }
      $totalTime = 0.0;
      $testCaseTimes = [];
      $testCases = $class->xpath('testCaseMethod');
      foreach ($testCases as $testCase) {
        $shortName = (string) $testCase->attributes()['name'];
        $fullName = $reflection->getName() . '::' . $shortName;
        $dataSet = $testCase->attributes()['dataSet'] ?? NULL;
        $cacheKey = $fullName;
        if ($dataSet !== NULL) {
          $cacheKey .= " with data set $dataSet";
          $shortName .= "@$dataSet";
        }
        $time = $this->resultCache->getTime($cacheKey);
        $testCaseTimes[] = [
          'testCase' => $shortName,
          'time' => $time,
        ];
        $totalTime += $time;
      }
      $map[$filename] = [
        'className' => $className,
        'time' => $totalTime,
        'testCases' => $testCaseTimes,
      ];
    }
    return $map;
  }

  /**
   * Sorts the map by execution time.
   *
   * @param TestMap $map
   *   The map to sort.
   *
   * @return TestMap
   *   The sorted map.
   */
  public function sortMap(array $map): array {
    \uasort($map, static function ($a, $b) {
      return $a['time'] <=> $b['time'];
    });
    return $map;
  }

}

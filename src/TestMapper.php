<?php

declare(strict_types=1);

namespace PhpUnitSplitter;

use PHPUnit\Runner\DefaultTestResultCache;
use PHPUnit\Runner\TestResultCache;

/**
 * Generates a map of test methods with their file name and execution time.
 */
final class TestMapper {

  private \SimpleXMLElement|FALSE $testsXml;
  private TestResultCache $resultCache;

  private string $prefix;

  public function __construct(string $testListFilePath, string $testResultFilePath, string $prefix) {
    $this->testsXml = \simplexml_load_file($testListFilePath);
    $this->resultCache = new DefaultTestResultCache($testResultFilePath);
    $this->prefix = $prefix;
  }

  public function getMap(): array {
    $this->resultCache->load();
    $map = [];
    $classesXpath = $this->testsXml->xpath('//testCaseClass');
    foreach ($classesXpath as $class) {
      $className = (string) $class->attributes()['name'];
      try {
        $reflection = new \ReflectionClass($className);
      } catch (\ReflectionException $e) {
        // Couldn't find the class.
        continue;
      }
      $filename = $reflection->getFileName();
      $filename = \str_replace($this->prefix, '', $filename);
      $map[$filename] = [
        'className' => $className,
        'time' => 0.0,
      ];
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
        $map[$filename][$shortName] = ['time' => $time];
        $map[$filename]['time'] += $time;
      }
    }
    return $map;
  }

  public function sortMap(array $map): array {
    uasort($map, function ($a, $b) {
      return $a['time'] <=> $b['time'];
    });
    return $map;
  }

}

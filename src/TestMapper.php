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

  public function __construct(string $testListFilePath, string $testResultFilePath) {
    $this->testsXml = \simplexml_load_file($testListFilePath);
    $this->resultCache = new DefaultTestResultCache($testResultFilePath);
  }

  public function getMap(): array {
    $this->resultCache->load();
    $map = [];
    $classesXpath = $this->testsXml->xpath('//testCaseClass');
    foreach ($classesXpath as $class) {
      $className = (string) $class->attributes()['name'];
      $reflection = new \ReflectionClass($className);
      $filename = $reflection->getFileName();
      $testCases = $class->xpath('testCaseMethod');
      foreach ($testCases as $testCase) {
        $testName = $reflection->getShortName() . '::' . $testCase->attributes()['name'];
        $dataSet = $testCase->attributes()['dataSet'] ?? NULL;
        if ($dataSet !== NULL) {
          $testName .= " with data set $dataSet";
        }
        $map[$testName] = [
          'path' => $filename,
          'time' => $this->resultCache->getTime($testName),
        ];
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

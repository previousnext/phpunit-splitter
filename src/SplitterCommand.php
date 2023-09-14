<?php

declare(strict_types=1);

namespace PhpUnitSplitter;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A symfony command for splitting PHPUnit tests.
 */
class SplitterCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure(): void {
    $this->addArgument('splits', InputArgument::OPTIONAL, "The number of splits", 1);
    $this->addArgument('index', InputArgument::OPTIONAL, "The index of the current split", 0);
    $this->addOption('tests-file', 't', InputOption::VALUE_REQUIRED, "The xml file listing all tests.", getcwd() . './tests.xml');
    $this->addOption('results-file', 'f', InputOption::VALUE_REQUIRED, "The results cache file.", getcwd() . '/.phpunit.result.cache', );
    $this->addOption('bootstrap-file', 'b', InputOption::VALUE_OPTIONAL, "The tests bootstrap file.", getcwd() . '/tests/bootstrap.php');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $bootstrap = $input->getOption('bootstrap-file');
    if (\file_exists($bootstrap)) {
      include_once $bootstrap;
    }
    // @todo validation
    $splits = (int) $input->getArgument('splits');
    $index = (int) $input->getArgument('index');
    $testsFile = $input->getOption('tests-file');
    $resultsFile = $input->getOption('results-file');

    $mapper = new TestMapper($testsFile, $resultsFile);
    $map = $mapper->sortMap($mapper->getMap());

    foreach ($this->split($map, $splits, $index) as $testName => $test) {
      $output->writeln("'" . \addslashes($testName) . "'" . ' ' . $test['path']);
    }

    return 0;
  }

  private function split(array $map, int $splits, int $index): array {
    $result = [];
    $keys = array_keys($map);
    $values = array_values($map);

    for ($i = $index; $i < count($map); $i++) {
      if (($i - $index) % $splits === 0) {
        $result[$keys[$i]] = $values[$i];
      }
    }

    return $result;
  }

}

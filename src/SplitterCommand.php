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
    $this->addArgument(
      'splits',
      InputArgument::OPTIONAL,
      "The number of splits",
      1,
    );
    $this->addArgument(
      'index',
      InputArgument::OPTIONAL,
      "The index of the current split",
      0,
    );
    $this->addOption(
      'tests-file',
      't',
      InputOption::VALUE_REQUIRED,
      "The xml file listing all tests.",
      \getcwd() . '/tests.xml',
    );
    $this->addOption(
      'results-files',
      'f',
      InputOption::VALUE_REQUIRED,
      "The results cache files.",
      \getcwd() . '/.phpunit.cache/test-results*',
    );
    $this->addOption(
      'bootstrap-file',
      'b',
      InputOption::VALUE_OPTIONAL,
      "The tests bootstrap file.",
      \getcwd() . '/tests/bootstrap.php',
    );
    $this->addOption(
      'prefix',
      'p',
      InputOption::VALUE_OPTIONAL,
      "The prefix to remove from the file names.",
      \getcwd() . '/',
    );
    $this->addOption(
      'json',
      'j',
      InputOption::VALUE_NONE,
      "Output the result as json.",
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    \set_error_handler(static fn($severity, $message, $file, $line) => throw new \ErrorException($message, 0, $severity, $file, $line));
    $bootstrap = $input->getOption('bootstrap-file');
    if (\file_exists($bootstrap)) {
      include_once $bootstrap;
    }
    // @todo validation
    $splits = (int) $input->getArgument('splits');
    $index = (int) $input->getArgument('index');
    $testsFile = $input->getOption('tests-file');
    $resultsFiles = $input->getOption('results-files');
    $prefix = $input->getOption('prefix');
    $json = $input->getOption('json');

    $mapper = new TestMapper($testsFile, $resultsFiles, $prefix);
    $map = $mapper->sortMap($mapper->getMap());

    $split = $this->split($map, $splits, $index);
    if ($json) {
      $output->writeln(\json_encode($split));
      return Command::SUCCESS;
    }
    foreach ($split as $testPath => $test) {
      $output->writeln($testPath);
    }

    return Command::SUCCESS;
  }

  /**
   * Splits the tests map into the given number of splits.
   *
   * @param array<string,array<string,float>> $map
   *   The map of tests.
   * @param int $splits
   *   The number of splits.
   * @param int $index
   *   The index of the current split.
   *
   * @return array<string,array<string,float>>
   *   The split map.
   */
  private function split(array $map, int $splits, int $index): array {
    $result = [];
    $keys = \array_keys($map);
    $values = \array_values($map);

    for ($i = $index; $i < \count($map); $i++) {
      if (($i - $index) % $splits === 0) {
        $result[$keys[$i]] = $values[$i];
      }
    }

    return $result;
  }

}

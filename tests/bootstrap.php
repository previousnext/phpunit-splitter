<?php

declare(strict_types = 1);

/**
 * @file
 * Boostrap for PHPUnit.
 */

use Drupal\Core\Extension\Discovery\RecursiveExtensionFilterIterator;
use Drupal\TestTools\PhpUnitCompatibility\ClassWriter;
use Symfony\Component\Dotenv\Dotenv;

assert_options(ASSERT_ACTIVE, FALSE);

$autoloader = __DIR__ . '/../vendor/autoload.php';
$loader = require $autoloader;

if (!defined('PHPUNIT_COMPOSER_INSTALL')) {
  define('PHPUNIT_COMPOSER_INSTALL', $autoloader);
}

// Start with classes in known locations.
$loader->add('Drupal\\Tests', __DIR__ . '/../vendor/drupal/core/tests');
$loader->add('Drupal\\KernelTests', __DIR__ . '/../vendor/drupal/core/tests');
$loader->add('Drupal\\FunctionalTests', __DIR__ . '/../vendor/drupal/core/tests');
$loader->add('Drupal\\FunctionalJavascriptTests', __DIR__ . '/../vendor/drupal/core/tests');
$loader->add('Drupal\\TestTools', __DIR__ . '/../vendor/drupal/core/tests');
class_exists('phpDocumentor\Reflection\DocBlockFactory');

if (!isset($GLOBALS['namespaces'])) {
  // Scan for arbitrary extension namespaces from core and contrib.
  $core = __DIR__ . '/../vendor/drupal/core';
  $extension_roots = [
    $core,
  ];

  $dirs = array_map(static function ($scan_directory) {
    $extensions = [];
    $filter = new RecursiveExtensionFilterIterator(new \RecursiveDirectoryIterator($scan_directory, \RecursiveDirectoryIterator::FOLLOW_SYMLINKS | \FilesystemIterator::CURRENT_AS_SELF), []);
    $filter->acceptTests(TRUE);
    $dirs = new \RecursiveIteratorIterator($filter);
    foreach ($dirs as $dir) {
      if (strpos($dir->getPathname(), '.info.yml') !== FALSE) {
        // Cut off ".info.yml" from the filename for use as the extension name.
        // We use getRealPath() so that we can scan extensions represented by
        // directory aliases.
        $extensions[substr($dir->getFilename(), 0, -9)] = $dir->getPathInfo()
          ->getRealPath();
      }
    }
    return $extensions;
  }, $extension_roots);
  $dirs = array_reduce($dirs, 'array_merge', []);
  $namespaces = [];
  foreach ($dirs as $extension => $dir) {
    if (is_dir($dir . '/src')) {
      // Register the PSR-4 directory for module-provided classes.
      $namespaces['Drupal\\' . $extension . '\\'][] = $dir . '/src';
    }
    if (is_dir($dir . '/tests/src')) {
      // Register the PSR-4 directory for PHPUnit test classes.
      $namespaces['Drupal\\Tests\\' . $extension . '\\'][] = $dir . '/tests/src';
    }
  }
  $GLOBALS['namespaces'] = $namespaces;
}
foreach ($GLOBALS['namespaces'] as $prefix => $paths) {
  $loader->addPsr4($prefix, $paths);
}

// @see https://www.drupal.org/node/3113653, and cores bootstrap.php.
ClassWriter::mutateTestBase($loader);

date_default_timezone_set('Australia/Sydney');

assert_options(ASSERT_ACTIVE, TRUE);
assert_options(ASSERT_EXCEPTION, TRUE);

// See https://symfony.com/doc/current/configuration.html#overriding-environment-values-via-env-local
// if you want to customise!
(new Dotenv())->usePutenv()->loadEnv(__DIR__ . '/../.env.dist');
(new Dotenv())->usePutenv()->loadEnv(__DIR__ . '/../.env');

<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use Ibexa\CodeStyle\PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->files()->name('*.php');

$config = new Config();
$config->setFinder($finder);

return $config;

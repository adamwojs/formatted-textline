<?php

declare(strict_types=1);

return EzSystems\EzPlatformCodeStyle\PhpCsFixer\Config::create()->setFinder(
    PhpCsFixer\Finder::create()
        ->in(__DIR__ . '/src')
        ->in(__DIR__ . '/tests')
        ->files()->name('*.php')
);

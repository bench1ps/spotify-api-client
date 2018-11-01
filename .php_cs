<?php

$dir = getenv('PHP_CS_FIXER_DIR') ?: __DIR__ . '/src';
$dirTests = getenv('PHP_CS_FIXER_DIR') ?: __DIR__ . '/tests';

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in($dir)
    ->in($dirTests)
    ->exclude('cache')
    ->exclude('logs')
    ->exclude('Resources')
    ->exclude('vendor')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'no_empty_phpdoc' => false,
        'ordered_imports' => true,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_order' => true,
        'phpdoc_summary' => false,
        'pre_increment' => false,
        'protected_to_private' => false,
        'return_type_declaration' => ['space_before' => 'one'],
    ])
    ->setUsingCache(true)
    ->setFinder($finder)
;

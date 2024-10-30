<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/database')
    ->in(__DIR__ . '/routes')
    ->in(__DIR__ . '/tests')
    ->name('*.php')
    ->notName('*.blade.php');

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'align_single_space'],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => ['statements' => ['return']],
        'cast_spaces' => true,
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => true,
        'function_typehint_space' => true,
        'include' => true,
        'lowercase_cast' => true,
        'native_function_casing' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => ['tokens' => ['extra']],
        'no_leading_import_slash' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'single_quote' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);

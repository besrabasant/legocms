<?php

$excluded_folders = [
    'node_modules',
    'storage',
    'vendor'
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($excluded_folders)
    ->notName('AcceptanceTester.php')
    ->notName('FunctionalTester.php')
    ->notName('UnitTester.php')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        '@PSR1' => true,
        'array_syntax' => ['syntax'=>'short'],
        'binary_operator_spaces' => ['align_double_arrow'=>true],
        'ordered_imports' => true,
        'align_multiline_comment' => true,
        'method_chaining_indentation' => true,
        'phpdoc_order' => true,
        'linebreak_after_opening_tag' => true,
        'not_operator_with_successor_space' => true,
        'implode_call' => true,
        'method_separation' => true,
        'native_function_invocation' => true,
        'dir_constant' => true,
        'native_constant_invocation' => true,
        'backtick_to_shell_exec' => true,
        'blank_line_before_return' => true,
    ])
    ->setFinder($finder)
;
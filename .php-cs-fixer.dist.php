<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        '@PSR12' => true,
        'single_quote' => false,
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'blank_line_after_namespace' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'if', 'switch', 'case'],
        ],
        'cast_spaces' => true,
        'concat_space' => ['spacing' => 'one'],
        'trim_array_spaces' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
    ])
    ->setFinder($finder)
;

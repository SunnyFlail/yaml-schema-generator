<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/src'])
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_whitespace_before_comma_in_array' => true,
        'normalize_index_brace' => true,
        'trim_array_spaces' => true,
        'no_multiple_statements_per_line' => true,
        'no_trailing_comma_in_singleline' => true,
        'single_line_empty_body' => true,
        'declare_strict_types' => true,
        'strict_comparison' => true,
        'array_indentation' => true,
        'compact_nullable_type_declaration' => true,
        'no_extra_blank_lines' => true,
        'no_spaces_around_offset' => true,
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
        'type_declaration_spaces' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;

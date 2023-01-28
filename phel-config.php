<?php

declare(strict_types=1);

return [
    'src-dirs' => ['src/phel'],
    'test-dirs' => ['tests/phel'],
    'vendor-dir' => 'vendor',
    'export' => [
        'directories' => ['src/phel'],
        'namespace-prefix' => 'PhelGenerated',
        'target-directory' => 'src/PhelGenerated',
    ],
    'out-dir' => 'out',
    'ignore-when-compiling' => ['src/phel/local.phel'],
];

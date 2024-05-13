<?php

declare(strict_types=1);

namespace Phel\Formatter;

use Gacela\Framework\AbstractConfig;
use Phel\Config\PhelConfig;

final class FormatterConfig extends AbstractConfig
{
    public const FORMAT_DIRS = PhelConfig::FORMAT_DIRS;

    private const DEFAULT_FORMAT_DIRS = ['src', 'tests'];

    public function getFormatDirs(): array
    {
        return $this->get(self::FORMAT_DIRS, self::DEFAULT_FORMAT_DIRS);
    }
}

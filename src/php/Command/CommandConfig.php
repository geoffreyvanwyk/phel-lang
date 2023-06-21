<?php

declare(strict_types=1);

namespace Phel\Command;

use Gacela\Framework\AbstractConfig;
use Phel\Command\Domain\CodeDirectories;

final class CommandConfig extends AbstractConfig
{
    public const SRC_DIRS = 'src-dirs';
    public const TEST_DIRS = 'test-dirs';
    public const VENDOR_DIR = 'vendor-dir';
    public const OUTPUT_DIR = 'out-dir';
    public const OUTPUT_MAIN_NS = 'out-main-ns';

    private const DEFAULT_VENDOR_DIR = 'vendor';
    private const DEFAULT_SRC_DIRS = ['src'];
    private const DEFAULT_TEST_DIRS = ['tests'];
    private const DEFAULT_OUT_DIR = 'out';
    private const DEFAULT_OUTPUT_MAIN_NS = '';

    public function getCodeDirs(): CodeDirectories
    {
        return new CodeDirectories(
            (array)$this->get(self::SRC_DIRS, self::DEFAULT_SRC_DIRS),
            (array)$this->get(self::TEST_DIRS, self::DEFAULT_TEST_DIRS),
            (string)$this->get(self::OUTPUT_DIR, self::DEFAULT_OUT_DIR),
        );
    }

    public function getVendorDir(): string
    {
        return (string)$this->get(self::VENDOR_DIR, self::DEFAULT_VENDOR_DIR);
    }

    public function getOutputMainNs(): string
    {
        return (string)$this->get(self::OUTPUT_MAIN_NS, self::DEFAULT_OUTPUT_MAIN_NS);
    }
}

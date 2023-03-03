<?php

namespace Bermuda\Detector;

class ConfigProvider extends \Bermuda\Config\ConfigProvider
{
    protected function getInvokables(): array
    {
        return [FinfoDetector::class]; 
    }

    protected function getAliases(): array
    {
        return [MimeTypeDetector::class => FinfoDetector::class];
    }
}

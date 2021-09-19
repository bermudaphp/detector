<?php

namespace Bermuda\Detector;

interface ExtensionDetector
{
    public function detectExtension(string $content): string ;
}

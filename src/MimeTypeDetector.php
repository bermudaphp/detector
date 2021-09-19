<?php

namespace Bermuda\Detector;

interface MimeTypeDetector
{
    public function detectMimeType(string $content): string ;
}

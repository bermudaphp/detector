<?php

namespace Bermuda\Detector;

interface MimeTypeDetector
{
    public function detectMimeType(string $content):? string ;
    public function detectFileMimeType(string $filename):? string ;
}

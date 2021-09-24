<?php

namespace Bermuda\Detector;

interface ExtensionDetector
{
    public function detectExtension(string $content):? string ;
    public function detectFileExtension(string $filename):? string ;
}

<?php

interface MimeTypeDetector
{
    public function detectMimeType(string $content): string ;
}

<?php

namespace Bermuda\Detector;

final class FinfoDetector implements ContentDetector
{
    public function detectMimeType(string $content): string
    {
        return $this->finfoBuffer(FILEINFO_MIME_TYPE, $content);
    }

    public function detectExtension(string $content): string
    {
        return $this->finfoBuffer(FILEINFO_EXTENSION, $content);
    }

    /**
     * @param string $content
     * @param string $mode
     * @return string
     */
    private function finfoBuffer(string $mode, string $content): string
    {
        return (new \finfo($mode))->buffer($content);
    }
}

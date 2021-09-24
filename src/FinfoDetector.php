<?php

namespace Bermuda\Detector;

use finfo;
use Devanych\Mime\MimeTypes;

final class FinfoDetector implements ContentDetector
{
    /**
     * @param string $filename
     * @return string
     */
    public function detectFileMimeType(string $filename): string
    {
        return $this->detectMimeType(file_get_contents($filename));
    }

    /**
     * @param string $content
     * @return string
     */
    public function detectMimeType(string $content): string
    {
        return $this->finfoBuffer(FILEINFO_MIME_TYPE, $content);
    }
    
    /**
     * @param string $filename
     * @return string
     */
    public function detectFileExtension(string $filename): string
    {
        return $this->detectExtension(file_get_contents($filename));
    }

    /**
     * @param string $content
     * @return string
     */
    public function detectExtension(string $content): string
    {
        $ext = $this->finfoBuffer(FILEINFO_EXTENSION, $content);

        if ($ext === '???') {
            $mimeType = $this->detectMimeType($content);
            return (new MimeTypes)->getExtensions($mimeType);
        }

        return $ext;
    }

    /**
     * @param string $content
     * @param string $mode
     * @return string
     */
    private function finfoBuffer(string $mode, string $content): string
    {
        return (new finfo($mode))->buffer($content);
    }
}

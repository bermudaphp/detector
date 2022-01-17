<?php

namespace Bermuda\Detector;

use finfo;
use Devanych\Mime\MimeTypes;

final class FinfoDetector implements Detector
{
    /**
     * @param string $filename
     * @return string|null
     * @throws \RuntimeException if read file is failed
     */
    public function detectFileMimeType(string $filename):? string
    {
        return $this->detectMimeType($this->readFile($filename));
    }

    /**
     * @param string $content
     * @return string|null
     */
    public function detectMimeType(string $content):? string
    {
        $mimeType = $this->finfoBuffer(FILEINFO_MIME_TYPE, $content);
        return $mimeType === '???' ? null : $mimeType;
    }

    /**
     * @param string $filename
     * @return string|null
     * @throws \RuntimeException if read file is failed
     */
    public function detectFileExtension(string $filename):? string
    {
        $content = $this->readFile($filename);
        $extension = $this->finfoBuffer(FILEINFO_EXTENSION, $content);
        
        if (str_contains($extension, '/')) {
            return explode('/', $extension, 2)[0];
        }

        if ($extension === '???') {
            if (($extensions = $this->getExtensions($content)) === []) {
                return null;
            }
            
            $extensions = array_map('strtolower', $extensions);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            if (in_array(strtolower($extension), $extensions)) {
                return $extension;
            }
            
            return array_shift($extensions);
        }
        
        return $extension;
    }

    /**
     * @param string $content
     * @return string|null
     */
    public function detectExtension(string $content):? string
    {
        $extension = $this->finfoBuffer(FILEINFO_EXTENSION, $content);

        if (str_contains($extension, '/')) {
            return explode('/', $extension, 2)[0];
        }

        if ($extension === '???') {
            $extensions = $this->getExtensions($content);
            return $extensions !== [] ? array_shift($extensions) : null ;
        }

        return $extension;
    }

    /**
     * @param string $filename
     * @return string
     * @throws \RuntimeException
     */
    private function readFile(string $filename): string
    {
        $content = @file_get_contents($filename);

        if (($err = error_get_last()) != null){
            throw new \RuntimeException($err['message']);
        }

        return $content;
    }

    private function getExtensions(string $content): array
    {
        $mimeType = $this->detectMimeType($content);
        return (new MimeTypes)->getExtensions($mimeType);
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

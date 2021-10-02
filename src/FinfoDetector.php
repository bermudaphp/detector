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

        $ext = $this->finfoBuffer(FILEINFO_EXTENSION, $content);

        if ($ext === '???') {

            $result = $this->getExtensions($content);
            
            if ($result === []) {
                return null;
            }
            
            $result = array_map('strtolower', $result);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $result)) {
                return $ext;
            }
            
            return array_shift($result);
        }
        
        return $ext;
    }

    /**
     * @param string $content
     * @return string|null
     */
    public function detectExtension(string $content):? string
    {
        $ext = $this->finfoBuffer(FILEINFO_EXTENSION, $content);

        if ($ext === '???') {
            $result = $this->getExtensions($content);
            return $result !== [] ? array_shift($result) : null ;
        }

        return $ext;
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

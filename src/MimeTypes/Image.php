<?php

namespace Bermuda\Detector\MimeTypes;

final class Image
{
    public const gif                = 'image/gif';
    public const jpeg               = 'image/jpeg';
    public const pjpeg              = 'image/pjpeg';
    public const png                = 'image/png';
    public const svg                = 'image/svg+xml';
    public const tiff               = 'image/tiff';
    public const vnd_microsoft_icon = 'image/vnd.microsoft.icon';
    public const vnd_wap_wbmp       = 'image/vnd.wap.wbmp';
    public const webp               = 'image/webp';
    
    public static function getTypes(): array
    {
        return [
            self::gif,
            self::jpeg,
            self::png,
            self::pjpeg,
            self::svg,
            self::tiff,
            self::vnd_microsoft_icon,
            self::vnd_wap_wbmp,
            self::webp,
        ];
    }
}

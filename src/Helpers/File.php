<?php

namespace Validationable\Helpers;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use SplFileInfo;
use Throwable;

final class File
{
    public static function mtime($file): int
    {
        return match (true) {
            Str::of($file) && is_file($file) => filemtime($file),
            is_resource($file) => fstat($file)['mtime'],
            is_a($file, SplFileInfo::class) && $file->isFile() => filemtime($file->getRealPath()),
            default => 0
        };
    }

    public static function size($file): int
    {
        return match (true) {
            Str::of($file) && is_file($file) => filesize($file),
            is_resource($file) => fstat($file)['size'],
            is_a($file, SplFileInfo::class) && $file->isFile() => filesize($file->getRealPath()),
            default => 0
        };
    }

    public static function mimes($file): string
    {
        $mimes = match (true) {
            Str::of($file) && is_file($file) => explode('/', mime_content_type($file)),
            is_resource($file) => explode('/', mime_content_type($file)),
            is_a($file, SplFileInfo::class) && $file->isFile() => explode('/', mime_content_type($file->getRealPath())),
            default => []
        };
        return str_replace(['+xml'], '', strtolower($mimes[1] ?? ''));
    }

    /**
     * @param $file
     * @throws Throwable
     */
    public static function image($file): Image
    {
        static $manager;

        if(!in_array(self::mimes($file), ['jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'avif'])) {
            throw new \Exception('Invalid image');
        };

        if($manager === null) {
            $method = extension_loaded('imagick') ? 'imagick' : 'gd';
            $manager = ImageManager::{$method}();
        }

        return $manager->read($file);
    }

    /**
     * @throws Throwable
     */
    public static function isImageCompare($file, callable $condition): bool
    {
        return $condition(self::image($file));
    }

    /**
     * @throws Throwable
     */
    public static function imageRatio($file): float
    {
        return self::image($file)->width() / self::image($file)->height();
    }
}
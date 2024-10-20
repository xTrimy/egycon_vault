<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

final class FilesHelper
{

    /**
     * Compresses and saves an image
     *
     * @param UploadedFile $uploadedFile
     * @param string $path
     * @param int $quality
     * @return string The name of the saved image
     */
    public static function compressAndSave(UploadedFile $uploadedFile, $path, $quality = 75): string
    {
        $image_name = time() . '-' . $uploadedFile->getClientOriginalName();
        $tmp_path = $uploadedFile->store('imgs', 'tmp');
        $image = Image::make(Storage::disk('tmp')->path($tmp_path));
        $image->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->encode('jpg', $quality);
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }
        self::createDirectory(public_path($path));
        $image->save(public_path($path . $image_name));
        try {
            unlink(Storage::disk('tmp')->path($tmp_path));
            throw new NoFileException("No file exception");
        } catch (\Exception $e) {
            Log::channel('filelog')->error("Could not delete file: " . $tmp_path . ", error: " . $e->getTraceAsString());
        }
        return $image_name;
    }

    // create recursive directory if not exists
    public static function createDirectory($path)
    {
        $dirs = explode('/', $path);
        $dir = '';
        foreach ($dirs as $part) {
            $dir .= $part . '/';
            if (!is_dir($dir) && strlen($dir) > 0) {
                mkdir($dir);
            }
        }
    }
}

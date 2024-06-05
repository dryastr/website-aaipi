<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Upload File
     */
    public static function upload($fileContent, $ext, $path = null, $filename = null, $type = null, $userId = null): bool|array
    {
        ini_set('memory_limit', '-1');

        if (! $filename) {
            $filename = Str::uuid()->toString().'_'.now()->timestamp;
        }

        $filename .= ".{$ext}";

        if ($userId) {
            $filename = "{$userId}_{$filename}";
        }

        if ($type) {
            $filename = "{$type}/{$filename}";
        }

        if (Storage::disk('assets')->put("{$path}/{$filename}", $fileContent)) {
            $file_size = Storage::disk('assets')->size("{$path}/{$filename}");

            return [
                'path' => $path,
                'filename' => "{$path}/{$filename}",
                'ext' => $ext,
                'file_size' => $file_size,
            ];
        }

        return false;
    }

    /**
     * Delete Image
     */
    public static function delete($path): bool
    {
        return Storage::disk('assets')->delete($path);
    }
}

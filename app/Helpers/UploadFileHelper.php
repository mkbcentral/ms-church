<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class UploadFileHelper
{
    /**
     * Make upload file with api
     * @param $file
     * @param string $directory
     * @param string $type
     * @param string $disk
     * @return string|null
     */
    public  static function uploadFile(
        $file,
        string $directory,
        string $type = "audio",
        string $disk = 'public'
    ): ?string{
        if ($file != null) {
            if ($type == "audio") {
                $filename = time() . '.mp3';
            } else {
                $filename = time() . '.png';
            }
            Storage::disk($disk)->put($directory . $filename, base64_decode($file));
            return  $directory . $filename;
        }else{
            return null;
        }
    }

    /**
     * Delete a file from the server
     * @param $path
     * @param string $disk
     * @return void
     */
    public static function deleteFileOnDisk($path, string $disk = 'public'): void
    {
        Storage::disk($disk)->delete($path);
    }
}

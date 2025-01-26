<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileHandler
{
    public function storeFile($file, $path, $disk = 'public')
    {
        if ($file && $file->isValid()) {
            return $file->store($path, $disk);
        }

        return null;
    }

    public function updateFile($file, $oldFilePath, $path, $disk = 'public')
    {
        if ($file && $file->isValid()) {
            $newFilePath = $this->storeFile($file, $path, $disk);

            if ($oldFilePath && Storage::disk($disk)->exists($oldFilePath)) {
                Storage::disk($disk)->delete($oldFilePath);
            }

            return $newFilePath;
        }

        return $oldFilePath;
    }
}

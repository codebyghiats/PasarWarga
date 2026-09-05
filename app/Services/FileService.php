<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Store an uploaded file and return the stored path.
     */
    public function storeUpload(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }

    /**
     * Delete a previously stored file.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Replace an old file with a new upload.
     */
    public function replace(?string $oldPath, UploadedFile $file, string $folder): string
    {
        $this->delete($oldPath);
        return $this->storeUpload($file, $folder);
    }
}

<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HandlesImageUploads
{
    protected function storeImageUpload(?UploadedFile $file, string $folder): ?string
    {
        if (!$file) {
            return null;
        }

        $directory = public_path('images/' . $folder);
        File::ensureDirectoryExists($directory);

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $filename = Str::uuid()->toString() . '.' . $extension;

        $file->move($directory, $filename);

        return $filename;
    }
}

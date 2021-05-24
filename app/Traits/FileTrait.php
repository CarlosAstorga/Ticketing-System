<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function deleteDirectory($directory)
    {
        return Storage::deleteDirectory($directory);
    }
}

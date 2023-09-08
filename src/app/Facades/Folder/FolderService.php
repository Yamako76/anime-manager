<?php

namespace App\Facades\Folder;

use Illuminate\Support\Facades\Facade;

class FolderService extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'FolderService';
    }
}

<?php

namespace App;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Setup
{
    const MAIN_SQLITE = 'database/database.sqlite';
    const TEST_SQLITE = 'database/test_database.sqlite';
    const PHOTOS_FOLDER = 'public/photos';
    const PLACEHOLDER_IMAGE = 'placeholder.png';
    const PLACEHOLDER_IMAGE_FOLDER = 'resources';
    const UPLOAD_PHOTOS = 'storage/app/photos';

    public static function handleFoldersAndFiles()
    {
        if(! file_exists(self::MAIN_SQLITE)) {
            echo "Setting up main sqlite database (" . self::MAIN_SQLITE . ")." .PHP_EOL;
            touch(self::MAIN_SQLITE);
        }

        if(! file_exists(self::TEST_SQLITE)) {
            echo "Setting up test sqlite database (" . self::TEST_SQLITE . ")." .PHP_EOL;
            touch(self::TEST_SQLITE);
        }

        if(! file_exists(self::PHOTOS_FOLDER)) {
            echo "Setting up photos folder (" . self::PHOTOS_FOLDER . ")." .PHP_EOL;
            mkdir(self::PHOTOS_FOLDER);
        }

        if(! file_exists(self::UPLOAD_PHOTOS)) {
            echo "Setting up photos upload folder (" . self::UPLOAD_PHOTOS . ")." .PHP_EOL;
            symlink('../../' . self::PHOTOS_FOLDER, self::UPLOAD_PHOTOS);
        }

        $placeholderTarget = self::PHOTOS_FOLDER . '/' . self::PLACEHOLDER_IMAGE;
        $placeholderSource = self::PLACEHOLDER_IMAGE_FOLDER . '/' . self::PLACEHOLDER_IMAGE;
        if(! file_exists($placeholderTarget)) {
            echo "Cooping placeholder photo (" . self::PLACEHOLDER_IMAGE . ")." .PHP_EOL;
            copy($placeholderSource, $placeholderTarget);
        }

        echo "Done." .PHP_EOL;
    }
}
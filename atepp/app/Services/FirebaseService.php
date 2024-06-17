<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseService
{
    protected $storage;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(base_path('/secret/atepp-cc0b7-firebase-adminsdk-70a8h-16c537cd23.json'));
        $this->storage = $factory->createStorage();
    }

    public function uploadFile($localFilePath, $subfolder, $name)
    {
        $bucket = $this->storage->getBucket();
        $file = fopen($localFilePath, 'r');
        $fullPath = rtrim($subfolder, '/') . '/' . $name;
        
        $object = $bucket->upload($file, [
            'name' => $fullPath
        ]);

        return $object->info()['mediaLink'];
    }
}

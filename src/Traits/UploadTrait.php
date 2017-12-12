<?php

namespace App\Traits;

use Knp\DoctrineBehaviors\Model\Sluggable\Transliterator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait UploadTrait
{
    public function uploadFile(UploadedFile $uploadedFile, $uploadDirectory = null)
    {
        $directory = $uploadDirectory ?? sprintf('cms/%s/%s', date('Y'), date('m'));
        $transliterator = new Transliterator();
        $name = sprintf('%s.%s', $transliterator->transliterate(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME), '-'), $uploadedFile->getClientOriginalExtension());

        // Avoid override
        if (file_exists(sprintf('%s/%s/%s', getenv('MEDIA_PATH'), $directory, $name))) {
            $name = sprintf('%s-%s', time(), $name);
        }

        $uploadedFile->move(sprintf('%s/%s', getenv('MEDIA_PATH'), $directory), $name);

        return sprintf('%s/%s', $directory, $name);
    }
}

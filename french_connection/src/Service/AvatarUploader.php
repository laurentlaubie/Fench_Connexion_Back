<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarUploader
{
    public function rename(UploadedFile $image)
    {
        return uniqid() . '.' . $image->guessExtension();
    }

    public function upload(?UploadedFile $image)
    {
        if ($image !== null) {
            $newFileName =  $this->rename($image);

            $image->move($_ENV['AVATAR_PICTURE'], $newFileName);

            return $newFileName;
        }

        return null;
    }
}

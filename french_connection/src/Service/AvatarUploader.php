<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarUploader
{
    public function rename(UploadedFile $image, $userId)
    {
        return 'avatarUser' . $userId . '.' . $image->guessExtension();
    }

    public function upload(?UploadedFile $image, $userId)
    {
        if ($image !== null) {
            $newFileName =  $this->rename($image, $userId);

            $image->move($_ENV['AVATAR_PICTURE'], $newFileName);

            return $newFileName;
        }

        return null;
    }
}

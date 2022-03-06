<?php

namespace App\Services\User;

use Config;
use Storage;
use Image;
use Illuminate\Http\UploadedFile;

class ProfileImageService
{
    /**
     * saveProfileImage
     *
     * @param UploadedFile $image
     * @param integer $userId
     * @return string
     */
    public function saveProfileImage(UploadedFile $image, int $userId): string
    {
        $img = Image::make($image);

        $img->fit(64, 64, function($constraint) {
            $constraint->upsize();
        });

        $file_name = 'profile_' . $userId . '.' . $image->getClientOriginalExtension();
        Storage::put(Config::get('profile.storage_image_path') . $file_name, (string) $img->encode());

        return $file_name;
    }
}

<?php

namespace App\Services\User;

use App\Models\User;
use Config;
use Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Image;

class UpdateService
{
    /**
     * appendNullableAttribute
     *
     * @param array $input
     * @param array $data
     * @param User $user
     * @return array
     */
    public function appendNullableAttribute(array $input, array $data, User $user): array
    {
        if (!is_null($input['email'])) {
            $data['email'] = $input['email'];
        }

        if (!is_null($input['password'])) {
            $data['password'] = Hash::make($input['password']);
        }

        if (array_key_exists('profile_image', $input)) {
            $data['profile_image'] = $this->saveProfileImage($input['profile_image'], $user->id);
        } else {
            $data['profile_image'] = $user->profile_image ?? 'default.png';
        }

        return $data;
    }

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

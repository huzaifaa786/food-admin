<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHelper
{
    public static function saveImage($imagefile, $path)
    {
        $originalImage = $imagefile;

        $manager = new ImageManager(new Driver());

        $image = $manager->read($originalImage);
        $image->resize(1024, 1024);
        $originalPath = public_path() . '/' . $path . '/';
        $filename = rand(0, 100) . time() . '.' . $originalImage->getClientOriginalExtension();
        $image->save($originalPath . $filename);

        return $path . '/' . $filename;
    }

    public static function saveImageFromApi($base64Image, $path)
    {
        $originalImage = base64_decode($base64Image);

        $manager = new ImageManager(new Driver());

        $image = $manager->read($originalImage);

        $originalPath = public_path() . '/' . $path . '/';
        $filename = rand(0, 100) . time() . '.png';

        $image->toPng()->save($originalPath . $filename);

        return $path . '/' . $filename;
    }

    public function deleteImage($path)
    {
        $image_path = public_path() . $path;
        unlink($image_path);
    }


    // composer require intervention/image

    // in config/app.php add to $providers
    // Intervention\Image\ImageServiceProvider::class
    // add to aliases
    // 'Image' => Intervention\Image\Facades\Image::class

}

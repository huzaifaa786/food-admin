<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FileHelper
{
    public static function save($file, $path){
        // $fileName = 'file-'.time().'.'.$file->getClientOriginalExtension();

        // $file->storeAs($path, $fileName);

        // dd($path.$fileName);

        // return $path.$fileName;

            $filename = $file->getClientOriginalName();
            $Path = public_path().'/'.$path;
             $file->move($Path, $filename);
             return $path.$filename;
    }

    public static function saveFiles($files){
        $savedFiles = [];
        foreach ($files as $key => $file)
        {
            // Generate a file name with extension
            $fileName = 'file-'.time().$key.'.'.$file->getClientOriginalExtension();
            // Save the file

            $object = new stdClass();
            $object->name = 'File-'.($key+1);
            $object->handle = $file->storeAs('files', $fileName);
            $savedFiles[] = $object;
        }
        return $savedFiles;
    }

    public static function saveFile($file){
        // Generate a file name with extension
        $fileName = 'file-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file

        $object = new stdClass();
        $object->name = 'File-'. uniqid();
        $object->handle = $file->storeAs('video', $fileName);
        return $object->handle;
    }
    public static function saveCVFile($file){
        // Generate a file name with extension
        $fileName = 'file-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file

        $object = new stdClass();
        $object->name = 'File-'. uniqid();
        $object->handle = $file->storeAs('cv', $fileName);
        return $object->handle;
    }


    public static function saveVideoFromApi($base64Video, $path){
        $decodedVideo = base64_decode(str_replace('data:video/mp4;base64,', '', $base64Video));
        //$decodedVideo=file_put_contents('sample.mp4',base64_decode($base64Video,true));

       // $originalPath = storage_path('app/'.$path.'/'); // Path inside storage/app
        $filename = rand(0, 100) . time() . '.mp4';

        Storage::put($path.'/'.$filename, $decodedVideo); // Store the video

        return $path.'/'.$filename;
    }


}

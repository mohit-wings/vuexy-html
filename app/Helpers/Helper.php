<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadImage')) {

    function uploadImage($image, $dir, $unlink = null)
    {
        $request = request();

        if ($request->hasFile($image)) {
            $file = $request->file($image);
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $path = $file->storeAs($dir, $fileName);
            if ($unlink) {
                Storage::delete($unlink);
            }
            return $path;
        }

        return $unlink ? $unlink : NULL;
    }
}

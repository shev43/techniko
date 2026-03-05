<?php

    namespace App\Helper;

    use Intervention\Image\Facades\Image;

    trait UploadFile {

        public function uploadPhoto($file, $path, $width, $height) {
            $image = Image::make($file);

            $image->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $srcPath = 'storage/' . $path . '/' . $fileName;

            if($image->save(public_path($srcPath)))

                return response()->json($fileName, 200);
            else
                return response()->json('failed', 444);
        }

    }

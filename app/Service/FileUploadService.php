<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    // Image Upload
    public function imageUpload($request, $model, $path = 'uploads') {
        $request->validate([
            'file' => 'nullable|mimes:png,jpg'
        ]);

        if($request->file != null) {
            $uploadedFile = $request->file;

            if($model->file != null) {
                Storage::disk('public')->delete($model->file);
            }

            $file_link = Storage::disk('public')->putFileAs($path, $uploadedFile, uniqid().$model->id.'.'.$uploadedFile->getClientOriginalExtension());

            return Storage::url($file_link);
        }
    }
}

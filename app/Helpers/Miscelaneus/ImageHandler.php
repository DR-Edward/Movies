<?php
namespace App\Helpers\Miscelaneus;

use Illuminate\Support\Facades\Storage;

class ImageHandler {
    /**
     * @param File $image
     * 
     * @return string
     */
    public static function store($image) {

        $message_type = 'success';
        $message_text = 'Created';
        $code = 201;

        try{
            $stored = Storage::put('public/images', $image, 'public');
        }catch(\Exception $e){
            $code = 422;
            $message_type = 'error';
            $message_text = 'Can not store this file';
        }

        return [
            'link' => Storage::url($stored),
            'message_type' => $message_type,
            'message_text' => $message_text,
            'code' => $code
        ];
    }
}
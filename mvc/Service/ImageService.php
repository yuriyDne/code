<?php

namespace mvc\Service;

class ImageService
{
    const SAVE_IMAGE_ROOT = MVC_PATH.DS.'uploads';
    const RELATIVE_WEB_ROOT = '/mvc/uploads';

    /**
     * @param string $relativePath
     * @param string $imageData
     * @return string
     */
    public function storeFormDataUrl(string $relativePath, string $imageData){
        $saveDir = self::SAVE_IMAGE_ROOT.$relativePath;

        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0775, true);
        }

        $imageName = time().'.jpg';
        $filePath = $saveDir.DS.$imageName;
        $fileData = base64_decode($imageData);
        file_put_contents($filePath, $fileData);

        return self::RELATIVE_WEB_ROOT.$relativePath.'/'.$imageName;
    }
}
<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class ImageHelper{
    
    /**
     * ImageHelper::resize()
     * 
     * @param string $imageFilePath
     * @param mixed $width
     * @param mixed $height
     * @param bool $forceSize
     * @return mixed
     */
    public static function resize($imageFilePath, $width = null, $height = null, $forceSize = false)
    {
        $_imageFilePath=rawurldecode($imageFilePath);
        if(false === ($_imageFilePath = realpath(Yii::getPathOfAlias('root') .'/'. ltrim($imageFilePath,'/')))) {
            $_imageFilePath = $_SERVER['DOCUMENT_ROOT'].'/'.ltrim($imageFilePath,'/');
        }
        
        $imageFilePath = str_replace('\\', '/', $_imageFilePath);

        if(!is_file($imageFilePath) || !($imageInfo = @getimagesize($imageFilePath))) {
            return false;
        }
        
        $width  = (int)$width;
        $height = (int)$height;
        
        if(empty($width) && empty($height)) {
            return false;
        }
        
        list($originalWidth, $originalHeight) = $imageInfo;
        
        if(empty($width)) {
            $width = floor($originalWidth * $height / $originalHeight);
        } elseif(empty($height)) {
            $height = floor($originalHeight * $width / $originalWidth);
        }
        
        $md5File    = md5_file($imageFilePath);
        $filePrefix = substr($md5File, 0, 2) . substr($md5File, 10, 2) . substr($md5File, 20, 2) . substr($md5File, 30, 2);
        
        $baseResizeUrl  = Yii::app()->apps->getAppUrl('frontend', 'frontend/assets/files/resized/' . $width.'x'.$height, false, true) . '/';
        $baseResizePath = Yii::getPathOfAlias('root.frontend.assets.files.resized.' . $width.'x'.$height);
        
        $imageName      = $filePrefix . '-' . basename($imageFilePath);
        $alreadyResized = $baseResizePath . '/' . $imageName;
        
        $oldImageLastModified   = @filemtime($imageFilePath);
        $newImageLastModified   = 0;
        
        if($isAlreadyResized = is_file($alreadyResized)) {
            $newImageLastModified = @filemtime($alreadyResized);
        }

        if($isAlreadyResized && @getimagesize($alreadyResized) && $oldImageLastModified < $newImageLastModified) {
            return $baseResizeUrl . rawurlencode($imageName);
        }
            
        if(!file_exists($baseResizePath) && !@mkdir($baseResizePath, 0777, true)) {
            return false;       
        }
        
        require_once Yii::getPathOfAlias('common.vendors.PhpThumb') . '/ThumbLib.inc.php';
        
        try {
            
            $thumb = PhpThumbFactory::create($imageFilePath);
        
            if(!$forceSize) {
                $thumb->adaptiveResize($width, $height);
            } else {
                $thumb->resize($width, $height);
            }
    
            if(!$thumb->save($baseResizePath. '/' .$imageName)) {
                return false;
            }
        
        } catch (Exception $e) {
            
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            return false;
            
        }
            
        return $baseResizeUrl . rawurlencode($imageName);
    }
}
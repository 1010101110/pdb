<?php

/**
 * Class Image
 *
 * Handles everything regarding images.
 */
class Image
{
    public static function validateimage($image)
    {
        if (
            !isset($image['error']) ||
            is_array($image['error'])
        ) {
            return false;
        }
    
        // Check $_FILES['upfile']['error'] value.
        switch ($image['error']) {
            case UPLOAD_ERR_OK:
                break;
            default:
                return false;
        }
        
        return true;
    }
    
    public static function validatedestination($destination)
    {
        if(is_dir($destination) AND is_writable($destination))
        {
            return true;
        }
        else
        {
            if(mkdir($destination,0777,true)){
                //try to create the folder
                return true;
            }
            return false;
        }
    }
    
    public static function saveimage($image,$folder=null,$filename=null)
    {
        //check if the uploaded image is good
        if(!self::validateimage($image))
        {
            return false;
        }
        
        //check directory path is good
        $destination = Config::get('PATH_IMAGES') . '/';
        $destination .= $folder;
        if(!self::validatedestination($destination))
        {
            //failed desitnation
            Session::add('feedback_negative', "error writing file:" . $destination);
            return false;
        }

        //open image file
        $imageData = getimagesize($image['tmp_name']);
        $width = $imageData[0];
        $height = $imageData[1];
        $mimeType = $imageData['mime'];
        
        if (!$width || !$height) {
            Session::add('feedback_negative', "error width height file");
            return false;
        }

        switch ($mimeType) {
            case 'image/jpeg': $myImage = imagecreatefromjpeg($image['tmp_name']); break;
            case 'image/png': $myImage = imagecreatefrompng($image['tmp_name']); break;
            case 'image/gif': $myImage = imagecreatefromgif($image['tmp_name']); break;
            default:             
                Session::add('feedback_negative', "error mime file");
                return false;
        }
        
        //save image
        $fullpath = $destination . $filename . '.jpg';
        if(imagejpeg($myImage, $fullpath))
        {
            Session::add('feedback_positive', "image saved");
            HistoryModel::createHistory(Config::get('URL').'images/' . $folder . $filename . '.jpg','saved an image');
            return true;
        }
        else
        {
            Session::add('feedback_negative', "write failed:" .$fullpath);
            return false;
        }
    }
}

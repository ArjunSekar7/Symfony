<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{

    const IMAGE_INFO = "Successfully Uploaded";
    const ERROR_UPLOAD = "Error in uploading the image";
    const ERROR_IMAGE = "Please provide .jpg image format";
    const ERROR_INVAILD_MAIL = "Enter valid email and password";
    const ERROR_MAIL = "Invalid Mail";
    const ERROR_SEND_MAIL = "Error in Sending the Mail";
    const ERROR_ALREADY_REGISTERED = "Email Id already registered";
    const LOGGED_IN = "Successfully logged in...";

    /**
     * Method to render the template in twig
     * @param $twig
     * @param $form
     * @param $message
     * @param $data
     * 
     * returns Response 
     */

    public function renderTemplate($twig, $form, $message, $data)
    {
        return new Response($this->render($twig, [
            'form' => $form,
            'message' => $message,
            'data' => $data,
        ]));
    }

    /**
     * Method to make the thumbnail image
     * @param $thumbnail
     * 
     * returns path of thumbnail image 
     */

    public function makeThumbnail($thumbnail)
    {
        list($width, $height) = getimagesize($thumbnail);
        $fileName = $this->changeFileName($thumbnail);
        $src = $this->createImage($thumbnail);
        $dst = imagecreatetruecolor(100, 100);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, 100, 100, $width, $height);
        imagejpeg($dst, $this->getParameter('thumbnail_directory') . "/" . $fileName);
        return $this->getParameter('thumbnail_directory') . "/" . $fileName;
    }

    /**
     * Method to validate image 
     * @param $image
     * 
     * returns boolean
     */

    public function validateImage($image)
    {
        $fileName = $image->getClientOriginalName();
        $fileExt = explode(".", $fileName);
        if ($fileExt[1] == 'jpg' || $fileExt[1] == 'jpeg' || $fileExt[1] == 'png') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to image identifier representing the image obtained from the given filename
     * @param $image
     * 
     * returns image resource identifier
     */

    public function createImage($image)
    {
        $fileName = $image->getClientOriginalName();
        $fileExt = explode(".", $fileName);
        switch ($fileExt[1]) {
            case 'jpg':
            case 'jpeg':
                return imagecreatefromjpeg($image);
                break;
            case 'png':
                return imagecreatefrompng($image);
                break;
        }
    }

    /**
     * Method to change the file name 
     * @param $image
     * 
     * returns name of the image 
     */

    public function changeFileName($image)
    {
        $fileOrgName = $image->getClientOriginalName();
        $file = explode(".", $fileOrgName);
        $randBit = (string)rand(0,99999);
        return $file[0].$randBit.'.'.$file[1];
    }

    /**
     * Method to delete the file from the folder
     * @param $getImage
     * 
     */

    public function unLink($getImage)
    {
        unlink($getImage->getThumbnailPath());
        unlink($getImage->getOrginalImagePath());
    }
}

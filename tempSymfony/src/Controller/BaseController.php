<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{

    const IMAGE_INFO = "Successfully Uploaded";
    const ERROR_UPLOAD = "Error in uploading the image";
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
     * return Response 
     */

    public function renderTemplate($twig,$form,$message,$data)
    {
        return new Response($this->render($twig, [
            'form' => $form->createView(),
            'message' => $message,
            'data' => $data,
        ]), Response::HTTP_OK);
    }

    /**
     * Method to make the thumbnail image
     * @param $thumbnail
     * 
     * return path of thumbnail image 
     */

    public function makeThumbnail($thumbnail)
    {
        list($width, $height) = getimagesize($thumbnail);
        $fileName = $thumbnail->getClientOriginalName();
        $src = imagecreatefromjpeg($thumbnail);
        $dst = imagecreatetruecolor(100, 100);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, 100, 100, $width, $height);
        imagejpeg($dst, $this->getParameter('thumbnail_directory') . "/" . $fileName);
        return $this->getParameter('thumbnail_directory') . "/" . $fileName;
    }
}
<?php

namespace App\Controller;

use App\Entity\UploadImage;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\BaseController;
use App\Form\ImageUploadType;
use App\Form\UploadImageType;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    /**
     * Method to login the user
     * @param $request
     * 
     * return response
     */

    public function login(Request $request)
    {
        $user = new User;
        $message = $data = '';
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailId = $form->get('email')->getData();
            $verifyPassword = $form->get('password')->getData();
            $user = $this->getDoctrine()->getRepository(User::class);
            $check = $user->findOneBy(
                array('email' => $mailId)
            );
            if ($check === null) {
                $message = BaseController::ERROR_MAIL;
            } else {

                if ($check->getPassWord() == $verifyPassword) {
                    return new Response(BaseController::LOGGED_IN);
                } else {
                    $message = BaseController::ERROR_INVAILD_MAIL;
                }
            }
        }
        return $this->renderTemplate('users/login.html.twig', $form, $message, $data);
    }

    /**
     * Method to save the images path to database
     * @param $request
     * 
     * return response to user
     */

    public function imageUpload(Request $request)
    {
        $image = new UploadImage;
        $message = $data = '';
        $form = $this->createForm(UploadImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $thumbnail = $orginalImage = $form->get('orginal_image_path')->getData();
            if ($this->validateImage($orginalImage)) {
                $image->setThumbnailPath($this->makeThumbnail($thumbnail));
                $fileName = $this->changeFileName($orginalImage);
                $orginalImage->move($this->getParameter('image_directory'), $fileName);
                $filePath =  $this->getParameter('image_directory') . '/' . $fileName;
                $image->setOrginalImagePath($filePath);
                $entityManager->persist($image);
                $entityManager->flush();
                $message = BaseController::IMAGE_INFO;
            }
        }
        return $this->renderTemplate('users/UploadImage.html.twig', $form->createView(), $message, $image);
    }

    /**
     * Method to view all the images
     * @param $request
     * 
     * return response to twig
     */

    public function view()
    {
        $data = array(
            "listImage" => $this->getThumbnailImage(),
            "image" => null
        );
        return $this->renderTemplate('users/view.html.twig', null, null, $data);
    }

    /**
     * Method to get the original image based on id
     * @param $id
     * 
     * 
     * return response to twig
     */

    public function getImage($id, Request $request)
    {
        $getImage = $this->getDoctrine()->getManager()->getRepository(UploadImage::class)->findOneBy(
            array('id' => $id)
        );
        $data = array(
            "listImage" => $this->getThumbnailImage(),
            "image" => $getImage
        );
        return $this->renderTemplate('users/view.html.twig', null, null, $data);
    }

    /**
     * Method to get the original image based on id
     * @param $id
     * 
     * 
     * return response to twig
     */

    public function editImage($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getImage = $entityManager->getRepository(UploadImage::class)->findOneBy(
            array('id' => $id)
        );
        $form = $this->createForm(UploadImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->unLink( $getImage);
            $thumbnail = $orginalImage = $form->get('orginal_image_path')->getData();
            $getImage->setThumbnailPath($this->makeThumbnail($thumbnail));
            $fileName = $this->changeFileName($orginalImage);
            $orginalImage->move($this->getParameter('image_directory'), $fileName);
            $filePath =  $this->getParameter('image_directory') . '/' . $fileName;
            $getImage->setOrginalImagePath($filePath);
            $entityManager->persist($getImage);
            $entityManager->flush();
            return $this->redirect('/view');
        }
        return $this->renderTemplate('users/UploadImage.html.twig', $form->createView(), null, $getImage);
    }

    /**
     * Method to delete the original image based on id
     * @param $id
     * 
     * 
     * return response to twig
     */

    public function deleteImage($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getImage = $entityManager->getRepository(UploadImage::class)->findOneBy(
            array('id' => $id)
        );
        $this->unLink($getImage);
        $entityManager->remove($getImage);
        $entityManager->flush();
        return $this->redirect('/view');
    }

    /**
     * Method to get all thumbnail image from database
     * 
     * return $image 
     */

    public function getThumbnailImage()
    {
        $image = $this->getDoctrine()->getRepository(UploadImage::class)->findAll();
        return $image;
    }
}

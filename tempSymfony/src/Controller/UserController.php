<?php

namespace App\Controller;

use App\Entity\UploadImage;
use App\Entity\User;
use App\Form\ImageUploadType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /*public function login(Request $request)
    {
        $user = new User;
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        $message = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $mailId = $form->get('email')->getData();
            $verifyPassword = $form->get('password')->getData();
            $user = $this->getDoctrine()->getRepository(User::class);
            $check = $user->findOneBy(
                array('email' => $mailId)
            );
            if ($check === null) {
                $message = 'Invalid Mail';
            } else {

                if ($check->getPassWord() == $verifyPassword) {
                    return new Response("Successfully logged in...");
                } else {
                    $message = 'Enter valid email and password';
                }
            }
        }
        return $this->render('users/login.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }*/

    public function login(Request $request)
    {
        $image = new UploadImage;
        $form = $this->createForm(ImageUploadType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $file = $form->get('image')->getData();
            $fileName = $file->getClientOriginalName();
            $file->move($this->getParameter('image_directory'), $fileName);
            $filePath =  $this->getParameter('image_directory').'/'.$fileName;
            $image->setImage($filePath);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();
            return new Response("User photo is successfully uploaded.");
        }
        return $this->render('users/UploadImage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function addUserDetails()
    {
        $user = $this->getDoctrine()->getRepository(UploadImage::class)->findAll();
        return $this->render('users/view.html.twig', [
            'image' => $user,
        ]);
    }
}

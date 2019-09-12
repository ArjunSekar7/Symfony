<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserForm;
use App\Form\UserType;
use App\Form\AddUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/userLogin", name="user_login")
     */

    public function login(Request $request)
    {
        $user = new User;
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        $message = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $mailId = $form->get('mail_id')->getData();
            $password = $form->get('password')->getData();
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $user = $this->getDoctrine()->getRepository(User::class);
            $check = $user->findOneBy(
                array('mail_id' => $mailId)
            );
            if ($check === null) {
                $message ='Invalid Mail';
            } else {
                $verifyPassword = $check->getPassword();
                $session = new Session();
                $session->set('mailId', $mailId);
                $message = 'Enter valid email and password';
                if (password_verify($password, $verifyPassword)) {
                    $message = 'Login Successfull';
                }
            }
        }
        return $this->render('users/login.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }

    /**
     * @Route("/addUser", name="add_user")
     */

    public function addUserDetails(Request $request)
    {
        $userForm = new UserForm;
        $form = $this->createForm(AddUser::class, $userForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userForm->setName($form->get('name')->getData());
            $userForm->setEmailId($form->get('email_id')->getData());
            $userForm->setDateOfBirth($form->get('date_of_birth')->getData());
            $userForm->setGender($form->get('gender')->getData());
            $userForm->setComments($form->get('comments')->getData());
            $userForm->setCountry($form->get('country')->getData());

            $entityManager->persist($userForm);

            $entityManager->flush();
        }
        return $this->render('users/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/viewUser", name="view_user")
     */

    public function viewUser(Request $request)
    {
        $userList = $this->getDoctrine()->getRepository(UserForm::class)->findAll();
       /* return $this->render('users/register.html.twig', [
            'user' => $userList
        ]);*/
        return new Response();
    }
}

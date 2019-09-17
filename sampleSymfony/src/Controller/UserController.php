<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserForm;
use App\Form\UserType;
use App\Form\AddUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/userLogin", name="user_login")
     */

    public function login(Request $request, LoggerInterface $logger)
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
                $message = 'Invalid Mail';
            } else {
                $verifyPassword = $check->getPassword();
                $session = new Session();
                $session->set('mailId', $mailId);
                $message = 'Enter valid email and password';
                if (password_verify($password, $verifyPassword)) {
                    $logger->info('Login as ' . $mailId);
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

    public function addUserDetails(Request $request, ValidatorInterface $validator)
    {
        $userForm = new UserForm;
        $form = $this->createForm(AddUser::class, $userForm);
        $form->handleRequest($request);
        $flag = 0;
        $errorList = '';
        $errors = $validator->validate($userForm);
        if (count($errors) > 0) {
            $errorList = $errors;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getRepository(UserForm::class);
            $check = $user->findOneBy(
                array('email_id' => $form->get('email_id')->getData())
            );
            if ($check === null) {
                $entityManager = $this->getDoctrine()->getManager();
                $userForm->setName($form->get('name')->getData());
                $userForm->setEmailId($form->get('email_id')->getData());
                $userForm->setBirthdate($form->get('birthdate')->getData());
                $userForm->setGender($form->get('gender')->getData());
                $userForm->setComments($form->get('comments')->getData());
                $userForm->setCountry($form->get('country')->getData());

                $entityManager->persist($userForm);

                $entityManager->flush();
                $flag = 2;
            } else {
                $flag = 1;
            }
        }
        return $this->render('users/register.html.twig', [
            'form' => $form->createView(),
            'flag' => $flag,
            'errors' => $errorList,
        ]);
    }

    /**
     * @Route("/viewUser", name="view_user")
     */

    public function viewUser(Request $request)
    {
        $userList = $this->getDoctrine()->getRepository(UserForm::class)->findAll();
        return $this->render('users/view.html.twig', [
            'user' => $userList
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */

    public function updateAction($id, Request $request, ValidatorInterface $validator)
    {
        $user = new UserForm;
        $entityManager = $this->getDoctrine()->getManager();
        $getUser = $entityManager->getRepository(UserForm::class)->find($id);
        $form = $this->createForm(AddUser::class, $getUser);
        $errors = array();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setName($form->get('name')->getData());
            $user->setEmailId($form->get('email_id')->getData());
            $user->setBirthdate($form->get('birthdate')->getData());
            $user->setGender($form->get('gender')->getData());
            $user->setComments($form->get('comments')->getData());
            $user->setCountry($form->get('country')->getData());
            $entityManager->flush();
            return $this->redirectToRoute('view_user');
        } else {
            foreach ($form->getErrors(true, false) as $error) {
                $errors[] = $error->current()->getMessage();
            }
        }
        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }
}

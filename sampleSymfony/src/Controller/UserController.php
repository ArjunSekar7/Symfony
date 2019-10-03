<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Projects;
use App\Entity\User;
use App\Entity\UserForm;
use App\Form\UserType;
use App\Form\AddUser;
use App\Form\EmployeeType;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends AbstractController
{
    public function mail($mailer, String $password)
    {
        $session = new Session();
        $email = explode("@",$session->get('email'));
        $message = (new \Swift_Message('Hello Email'))
            ->setSubject('Verify mail')
            ->setFrom('nujraadream112@gmail.com')
            ->setTo($session->get('email'))
            ->setBody(
                $this->renderView(
                    'users/sentmail.html.twig',
                    [
                        'name' => $email[0],
                        'password' => $password
                    ]
                ),
                'text/html'
            );
        if ($mailer->send($message)) {
            return true;
        } else {
            return false;
        }
    }

    public function login(Request $request)
    {
        $user = new User;
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        $message = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $mailId = $form->get('mail_id')->getData();
            $verifyPassword = $form->get('password')->getData();
            $user = $this->getDoctrine()->getRepository(UserForm::class);
            $check = $user->findOneBy(
                array('email_id' => $mailId)
            );
            if ($check === null) {
                $message = 'Invalid Mail';
            } else {

                if ($check->getPassWord() == $verifyPassword) {
                    return $this->redirect('/user/list/1');
                } else {
                    $message = 'Enter valid email and password';
                }
            }
        }
        return $this->render('users/login.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }

    public function addUserDetails(Request $request, \Swift_Mailer $mailer)
    {
        $userForm = new UserForm;
        $form = $this->createForm(AddUser::class, $userForm);
        $form->handleRequest($request);
        $flag = 0;

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getRepository(UserForm::class);
            $check = $user->findOneBy(
                array('email_id' => $form->get('email_id')->getData())
            );
            if ($check === null) {
                $password = explode("@",  $form->get('email_id')->getData());
                $rand = (string) rand(5000, 9000);
                $password = $password[0] . $rand;
                $userForm->setPassword($password);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userForm);
                $entityManager->flush();
                $session = new Session();
                $session->set('email', $form->get('email_id')->getData());
                if ($this->mail($mailer, $password)) {
                    return $this->render('users/confirm.html.twig');
                } else {
                    return new Response("Error in Sending the Mail");
                }
            } else {
                $flag = 1;
            }
        }
        return $this->render('users/register.html.twig', [
            'form' => $form->createView(),
            'flag' => $flag,
        ]);
    }

    public function getDetails($page)
    {
        $list = $this->getDoctrine()
            ->getRepository(UserForm::class)
            ->getAllUserDetails($page);

        $totalDetailsReturned = $list->getIterator()->count();
        $totalList = $list->count();

        $maxPages = ceil($totalList / $totalDetailsReturned);

        return $this->render('users/view.html.twig', [
            'user' => $list,
            'maxPages' => $maxPages,
            'thisPage' => $page
        ]);
    }

    public function updateAction($id, Request $request)
    {
        $user = new UserForm;
        $entityManager = $this->getDoctrine()->getManager();
        $getUser = $entityManager->getRepository(UserForm::class)->find($id);
        $form = $this->createForm(AddUser::class, $getUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirect('/user/list/1');
        }
        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function userRegister(Request $request)
    {
        $employee = new Employee;
        $project = new Projects;

        $employeeForm = $this->createForm(EmployeeType::class, $employee);
        $projectForm = $this->createForm(ProjectType::class, $project);

        $employeeForm->handleRequest($request);
        $projectForm->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $data = null;
        $type = null;

        if ($employeeForm->isSubmitted()) {
            $type = 'employee';
            $id = $employeeForm->get('name')->getData()->getId();
            $data = $entityManager->getRepository(Employee::class)->find($id);
        }

        if ($projectForm->isSubmitted()) {
            $type = 'project';
            $id = $projectForm->get('name')->getData()->getId();
            $data = $entityManager->getRepository(Projects::class)->find($id);
        }

        return $this->render('Employee/employee.html.twig', [
            'employeeform' => $employeeForm->createView(),
            'projectform' => $projectForm->createView(),
            'data' => $data,
            'type' => $type
        ]);
    }
}

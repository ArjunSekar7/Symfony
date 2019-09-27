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
use Symfony\Component\Validator\Validator\ValidatorInterface;



class UserController extends AbstractController
{
    
    public function login(Request $request)
    {
        $user = new User;
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        $message = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $mailId = $form->get('mail_id')->getData();
            $password = $form->get('password')->getData();
            $user = $this->getDoctrine()->getRepository(User::class);
            $check = $user->findOneBy(
                array('mail_id' => $mailId)
            );
            if ($check === null) {
                $message = 'Invalid Mail';
            } else {
                $verifyPassword = $check->getPassword();
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

    public function addUserDetails(Request $request)
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
                $comments = "null";
                if ($form->get('comments')->getData()) {
                    $comments = $form->get('comments')->getData();
                }
                $entityManager = $this->getDoctrine()->getManager();                
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
        ]);
    }

    public function viewUser()
    {
        $userList = $this->getDoctrine()->getRepository(UserForm::class)->findAll();
        return $this->render('users/view.html.twig', [
            'user' => $userList
        ]);
    }

    public function updateAction($id, Request $request, ValidatorInterface $validator)
    {
        $user = new UserForm;
        $entityManager = $this->getDoctrine()->getManager();
        $getUser = $entityManager->getRepository(UserForm::class)->find($id);
        $form = $this->createForm(AddUser::class, $getUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('view_user');
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

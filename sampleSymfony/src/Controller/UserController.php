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
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserController extends BaseController
{
    /**
     * Method for user registeration 
     * @param $request
     * 
     * @return resposne to twig
     */

    public function register(Request $request, \Swift_Mailer $mailer)
    {
        $userForm = new UserForm;
        $session = new Session();
        $data ='';
        $message = '';
        $form = $this->createForm(AddUser::class, $userForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getRepository(UserForm::class);
            $check = $user->findOneBy(
                array('email_id' => $form->get('email_id')->getData())
            );
            if ($check === null) {
                $password = $this->encryptPassword($form->get('email_id')->getData());
                $session->set('email', $form->get('email_id')->getData());
                $userForm->setPassword($password);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userForm);
                $entityManager->flush();
                if ($this->mail($mailer, $password)) {
                    return $this->renderTemplate('users/confirm.html.twig', $form, $message,$data);
                } else {
                    return new Response(BaseController::ERROR_SEND_MAIL);
                }
            } else {
                $message = BaseController::ERROR_ALREADY_REGISTERED;
            }
        }

        return $this->renderTemplate('users/register.html.twig', $form, $message,$data);
    }

     /**
     * Method for list the user details
     * @param $page
     * 
     * @return response to twig
     */

    public function getUserDetails($page)
    {
        $form = $this->createForm(AddUser::class);
        $list = $this->getDoctrine()
            ->getRepository(UserForm::class)
            ->getAllUserDetails($page);
        $totalDetailsReturned = $list->getIterator()->count();
        $totalList = $list->count();
        $maxPages = ceil($totalList / $totalDetailsReturned);

        $data = array(
            'user' => $list,
            'maxPages' => $maxPages,
            'thisPage' => $page,
        );

        return $this->renderTemplate('users/view.html.twig',$form, null,$data);
    }

    /**
     * Method for update the user details
     * @param $request
     * @param $id
     * 
     * @return response to twig
     */

    public function update($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getUser = $entityManager->getRepository(UserForm::class)->find($id);
        $form = $this->createForm(AddUser::class, $getUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirect('/user/list/1');
        }
        
        return $this->renderTemplate('users/edit.html.twig',$form, null, null);
    }

    /**
     * Method for update the user details
     * @param $request
     * 
     * @return response to twig
     */

    public function list(Request $request)
    {
        $employee = new Employee;
        $project = new Projects;

        $data = null;
        $type = null;

        $employeeForm = $this->createForm(EmployeeType::class, $employee);
        $projectForm = $this->createForm(ProjectType::class, $project);

        $employeeForm->handleRequest($request);
        $projectForm->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
       

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
       
        // return $this->renderTemplate('Employee/employee.html.twig',$form, $type,$data);   
    }

    /**
     * Method for user to login 
     * @param $request
     * 
     * @return response to twig
     */

    public function login(Request $request)
    {
        $message = '';
        $data ='';
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User;
            $mailId = $form->get('mail_id')->getData();
            $verifyPassword = $form->get('password')->getData();
            $user = $this->getDoctrine()->getRepository(UserForm::class);
            $check = $user->findOneBy(
                array('email_id' => $mailId)
            );
            if ($check === null) {
                $message =  BaseController::ERROR_MAIL;
            } else {

                if ($check->getPassWord() == $verifyPassword) {
                    return $this->redirect('/user/list/1');
                } else {
                    $message = BaseController::ERROR_INVAILD_MAIL;
                }
            }
        }

        return $this->renderTemplate('users/login.html.twig', $form, $message,$data);
    }

    /**
     * Method to logout the user and clear the session
     * @param $session
     * 
     * @return to loginPage
     */

    public function logout(SessionInterface $session)
    {
        $session->clear();
        return $this->redirect('/userLogin');
    }
}

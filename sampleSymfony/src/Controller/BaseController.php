<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class BaseController extends AbstractController
{
    const ERROR_INVAILD_MAIL = "Enter valid email and password";
    const ERROR_MAIL = "Invalid Mail";
    const ERROR_SEND_MAIL = "Error in Sending the Mail";
    const ERROR_ALREADY_REGISTERED = "Email Id already registered";
    const ERROR_REQUEST = "Invaild Id passed";
    const HTTP_OK = "OK";
    const DATA_UPDATED = "Your detail is successfully updated";


    /**
     * Method to render the template in twig
     * @param $twig
     * @param $form
     * @param $message
     * @param $data
     * 
     * @return Response 
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
     * Method to send a jsonResponse to user
     * @param $errorCode
     * @param $errorMessage
     * @param $data
     * 
     * @return jsonResponse
     */

    public function sentJsonResponse($errorCode,$errorMessage,$data)
    {
        return 
            array(
                'error' => array(
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage
                ),
                'data' => $data
            );
        
    }

     /**
     * Method to create the dynamic password
     * @param $email
     * 
     * return password
     */

    public function encryptPassword($email)
    {
        $password = explode("@",  $email);
        $rand = (string) rand(5000, 9000);
        $password = $password[0] . $rand;

        return $password;
    }

    /**
     * Method to send a email
     * @param $mailer
     * @param $password
     * 
     * @return boolean
     */

    public function mail($mailer, String $password)
    {
        $session = new Session();
        $email = explode("@", $session->get('email'));
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
}
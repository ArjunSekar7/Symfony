<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;


class MainController extends AbstractController
{
    
    /**
     * @Route("/main", name="main")
     */

    public function index()
    {
       /* $session = new Session();
        $name = $session->get('name1');
        echo $name;
        return new Response();*/
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/lucky",name="luckyNumber")
     */

    public function lucky()
    {
        $num = random_int(0,10);
        //print_r($this->renderView('main/home.html.twig',['var'=>$num]));
        return $this->render('main/home.html.twig',['var'=>$num]);
         //return new Response();
    }

     /**
     * @Route("/userss",name="user")
     */

    public function display(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName('vijay');
        $user->setMailId('vijau.vijay@aspiresys.com');

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId());
    }

     /**
      * @Route("/display", name="displayUser")
     */

     public function displayAction()
     {
        //$repository = $this->getDoctrine()->getRepository(User::class)->findAll();
        //print_r($repository);
        //throw new \Exception('Something went wrong!');
        $session = new Session();
        $session->set('name1', 'Arjun1');
        //$request = new Request();
        //$request->server->get('HTTP_HOST');
        //$request->request->get('user');
        //print_r($request);
        /*$routeName = $request->attributes->get('displayUser');
        print_r($routeName);*/
        //return $this->redirectToRoute('main');
        return new Response();
        //return $this->render('sample/create.html.twig', array('data' => $data));
     }

     /**
      * @Route("/chart",name="chart")
     */

     public function chart()
     {
        $series = array(
            array("name" => "Series 1",    "data" => array(1,2,4,5,6,3,8)),
            array("name" => "Series 2",    "data" => array(2,6,8,1,3,7,12)),
            array("name" => "Series 3",    "data" => array(3,5,7,2,8,15,2))
        );
    
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  
        $ob->title->text('Sample Chart');
        $ob->xAxis->title(array('text'  => "y axis"));
        $ob->yAxis->title(array('text'  => "x axis"));
        $ob->series($series);
        return $this->render('main/chart.html.twig', array(
            'chart' => $ob
        ));
        //return new Response();
     }

     /**
      * @Route("/mail",name="mail")
      */

    public function mail(\Swift_Mailer $mailer)
    {
    $name = "Arjun";
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('nujraadream112@gmail.com')
            ->setTo('arjun.sekar@aspiresys.com')
            ->setBody(
            $this->renderView(
                'users/registration.html.twig',
                ['name' => $name]
            ),
            'text/html'
        )
    ;

    if($mailer->send($message))
    {
        echo "success";
    }
    else
    {
        echo "failure";
    }
    return new Response();
}

}

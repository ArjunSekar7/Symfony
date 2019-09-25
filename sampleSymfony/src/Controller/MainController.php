<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\MainCategory;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\Category;
use App\Form\ProductType;
use App\Form\SubCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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
        $num = random_int(0, 10);
        //print_r($this->renderView('main/home.html.twig',['var'=>$num]));
        return $this->render('main/home.html.twig', ['var' => $num]);
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

        return new Response('Saved new product with id ' . $user->getId());
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
            array("name" => "Series 1",    "data" => array(1, 2, 4, 5, 6, 3, 8)),
            array("name" => "Series 2",    "data" => array(2, 6, 8, 1, 3, 7, 12)),
            array("name" => "Series 3",    "data" => array(3, 5, 7, 2, 8, 15, 2))
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
            );

        if ($mailer->send($message)) {
            echo "success";
        } else {
            echo "failure";
        }
        return new Response();
    }

    /**
     * @Route("/getMainCategory",name="getMainCategory")
     */

    public function getMainCategory(Request $request)
    {
        $mainCategoryform = $this->createForm(Category::class);
        $mainCategoryform->handleRequest($request);

        $subCategoryform = $this->createForm(SubCategoryType::class);
        $subCategoryform->handleRequest($request);

        $productForm = $this->createForm(ProductType::class);
        $productForm->handleRequest($request);

        return $this->render('main/showList.html.twig', [
            'mainCategoryform' => $mainCategoryform->createView(),
            'subCategoryform' => $subCategoryform->createView(),
            'productForm' => $productForm->createView(),
        ]);
    }

    /**
     * @Route("/getSubCategory",name="getSubCategory")
     */

    public function getSubCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {

            $search = $request->request->get('id');

            $template = $entityManager->getRepository(SubCategory::class)->findBy(array(
                'mainCategory' => $search
            ));
            $idx = 0;
            foreach ($template as $mc) {
                $jsonData[$idx++] = array(
                    'id' => $mc->getId(),
                    'name' => $mc->getSubCategoryName()
                );
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('main/showList.html.twig');
        }
    }

    /**
     * @Route("/getproduct",name="getProducts")
     */

    public function getproduct(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $search = $request->request->get('id');

            $template = $entityManager->getRepository(Product::class)->findBy(array(
                'sub_category' => $search
            ));

            $idx = 0;
            foreach ($template as $mc) {
                $jsonData[$idx++] = array(
                    'id' => $mc->getId(),
                    'name' => $mc->getProductName()
                );
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('main/showList.html.twig');
        }
    }

    /**
     * @Route("/cache",name="store_cache")
     */

    public function cache()
    {
        $cachePool = new FilesystemAdapter('', 0, 'cache');

        $demoString = $cachePool->getItem('demo');
        if ($demoString->isHit()) {
            $demoString->set('hello world!!!!!!!');
            $cachePool->save($demoString);
        }

        if ($cachePool->hasItem('demo')) {
            $demoString = $cachePool->getItem('demo');
            echo $demoString->get();
            echo "\n";
        }

        //$cachePool->clear();

        if (!$cachePool->hasItem('demo')) {
            echo "The cache entry demo_string was deleted successfully!\n";
        }

        $demoOne = $cachePool->getItem('demo_array');
        if (!$demoOne->isHit()) {
            $demoOne->set(array("one", "two", "three"));
            $cachePool->save($demoOne);
        }

        if ($cachePool->hasItem('demo_array')) {
            $demoOne = $cachePool->getItem('demo_array');
            var_dump($demoOne->get());
            echo "\n";
        }

        return new Response();
    }
}

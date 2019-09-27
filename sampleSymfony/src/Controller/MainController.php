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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends AbstractController
{

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
    }

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

    public function getSubCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {

            $search = $request->request->get('id');

            if ($entityManager->getRepository(SubCategory::class)->findBy(array(
                'mainCategory' => $search
            ))) {
                $template = $entityManager->getRepository(SubCategory::class)->findBy(array(
                    'mainCategory' => $search
                ));
            } else {
                return new JsonResponse(
                    array(
                        'status' => 'error',
                        'message' => 'Invaild Id passed'
                    ),
                    500
                );
            }
            $idx = 0;
            foreach ($template as $mc) {
                $jsonData[$idx++] = array(
                    'id' => $mc->getId(),
                    'name' => $mc->getSubCategoryName()
                );
            }
            return new JsonResponse(
                array(
                    'status' => 'OK',
                    'message' => $jsonData
                ),
                200
            );
        } else {
            return new JsonResponse(
                array(
                    'status' => 'error',
                    'message' => 'Invalid request'
                ),
                500
            );
        }
    }

    public function getproduct(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $search = $request->request->get('id');

            if ($entityManager->getRepository(Product::class)->findBy(array(
                'sub_category' => $search
            ))) {
                $template = $entityManager->getRepository(Product::class)->findBy(array(
                    'sub_category' => $search
                ));
            } else {
                return new JsonResponse(
                    array(
                        'status' => 'error',
                        'message' => 'Invaild Id passed'
                    ),
                    500
                );
            };;

            $idx = 0;
            foreach ($template as $mc) {
                $jsonData[$idx++] = array(
                    'id' => $mc->getId(),
                    'name' => $mc->getProductName()
                );
            }
            return new JsonResponse(
                array(
                    'status' => 'OK',
                    'message' => $jsonData
                ),
                200
            );
        } else {
            return new JsonResponse(
                array(
                    'status' => 'error',
                    'message' => 'Invalid request'
                ),
                500
            );
        }
    }
}

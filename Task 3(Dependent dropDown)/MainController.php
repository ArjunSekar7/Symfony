<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\MainCategory;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends AbstractController
{

    /**
     * @Route("/getMainCategory",name="getMainCategory")
     */

    public function getMainCategory(Request $request)
    {
        $mainCategory = new MainCategory;
        $mainCategory = $this->getDoctrine()->getRepository(MainCategory::class)->findAll();

        if ($request->isXmlHttpRequest()) {

            $jsonData = array();
            $idx = 0;
            $temp = array(
                'id' => 0,
                'name' => "All"
            );
            $jsonData[$idx++] = $temp;
            foreach ($mainCategory as $mc) {
                $temp = array(

                    'id' => $mc->getId(),
                    'name' => $mc
                        ->getName()
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('main/showList.html.twig');
        }
    }

    /**
     * @Route("/getSubCategory",name="getSubCategory")
     */

    public function getSubCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {

            $search = $request->request->get('data');
            $templateRepository = $entityManager->getRepository(SubCategory::class);
            $template = $templateRepository->findAll();
            $idx = 0;
            foreach ($template as $mc) {
                $checkValue = $mc->getMainCategory()->getId();
                if ($checkValue == $search) {
                    $temp = array(
                        'id' => $mc->getId(),
                        'name' => $mc->getSubCategoryName()
                    );
                    $jsonData[$idx++] = $temp;
                }
                if ($search == 0) {
                    $temp = array(
                        'id' => $mc->getId(),
                        'name' => $mc->getSubCategoryName()
                    );
                    $jsonData[$idx++] = $temp;
                }
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

            $search = $request->request->get('data');
            $templateRepository = $entityManager->getRepository(Product::class);
            $template = $templateRepository->findAll();
            $idx = 0;
            foreach ($template as $mc) {
                $checkValue = $mc->getSubCategory()->getId();
                if ($checkValue == $search) {
                    $temp = array(
                        'id' => $mc->getId(),
                        'name' => $mc->getProductName()
                    );
                    $jsonData[$idx++] = $temp;
                }
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('main/showList.html.twig');
        }
    }
}

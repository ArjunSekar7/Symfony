<?php

namespace App\Controller;


use App\Entity\MainCategory;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\Category;
use App\Form\ProductType;
use App\Form\SubCategoryType;
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

}

<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\Category;
use App\Form\ProductType;
use App\Form\SubCategoryType;
use App\Controller\BaseController;
use App\Entity\MainCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends BaseController
{
    /**
     * Method for show the maincategory list
     * @param $request
     * @param $id
     * 
     * @return form object
     */

    public function getMainCategory(Request $request)
    {
        $mainCategory = new MainCategory();
        $mainCategory->addProduct(new Product);
        $mainCategory->addSubCategoryName(new SubCategory);

        $mainCategoryform = $this->createForm(Category::class,$mainCategory);
        $mainCategoryform->handleRequest($request);
        
        return $this->renderTemplate('main/showList.html.twig', $mainCategoryform, null,null);
    }

    /**
     * Method for get the subcategory list
     * @param $request 
     * @param $id
     * 
     * @return JsonResponse
     */

    public function getSubCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $search = $request->request->get('id');

            if ($entityManager->getRepository(SubCategory::class)->findBy(array(
                'mainCategory' => $search
            ))) {
                return new JsonResponse($this->sentJsonResponse(201, BaseController::HTTP_OK, $entityManager->getRepository(SubCategory::class)->findByCategory($search)));
            } else {
                return new JsonResponse($this->sentJsonResponse(101,BaseController::ERROR_REQUEST, null));
            }
        } else {
            return new JsonResponse($this->sentJsonResponse(101,BaseController::ERROR_REQUEST, null));
        }
    }

    /**
     * Method for get product list
     * @param $request
     * @param $id
     * 
     * @return JsonResponse
     */

    public function getproduct(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $search = $request->request->get('id');

            if ($entityManager->getRepository(Product::class)->findBy(array(
                'sub_category' => $search
            ))) {
                return new JsonResponse($this->sentJsonResponse(201, BaseController::HTTP_OK, $entityManager->getRepository(Product::class)->findByCategory($search)));
            } else {
                return new JsonResponse($this->sentJsonResponse(101, BaseController::ERROR_REQUEST, null));
            }
        } else {
            return new JsonResponse($this->sentJsonResponse(101, BaseController::ERROR_REQUEST, null));
        }
    }
}

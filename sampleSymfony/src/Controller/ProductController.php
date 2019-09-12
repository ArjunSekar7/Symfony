<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/addproduct", name="Product_add")
     */
    public function login(Request $request)
    {
        $product =new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        print_r($form->getErrors());
        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
       
    }
}

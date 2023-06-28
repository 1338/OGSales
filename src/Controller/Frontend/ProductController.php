<?php

namespace App\Controller\Frontend;

use App\Entity\Catalog\CatalogItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_frontend_product')]
    public function index(CatalogItem $catalogItem): Response
    {
        return $this->render('frontend/product/index.html.twig', [
            'product' => $catalogItem
        ]);
    }
}

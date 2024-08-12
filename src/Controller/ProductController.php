<?php

namespace App\Controller;

use App\Controller\admin\BaseController;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product', name: 'product.')]
class ProductController extends BaseController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $repo): Response
    {
        $products = $repo->getProductPaginator();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Product $product, int $id): Response
    {
        $product = $this->getRepository(Product::class)->find($id);

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(): Response
    {
        $products = $this->getRepository(Product::class)->findBy([], ['id' => 'DESC']);
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
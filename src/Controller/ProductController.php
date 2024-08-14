<?php

namespace App\Controller;

use App\Controller\admin\BaseController;
use App\Entity\Product;
use App\Entity\ProductPhotos;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


        $productPhotos = $this->getRepository(ProductPhotos::class)->findByProduct($product);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'productPhotos' => $productPhotos
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, Product $product = null): Response
    {
        $products = $this->getRepository(Product::class)->findBy([], ['id' => 'DESC']);

        if (!$product) $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->save($product);

            return $this->flashRedirect('success', 'Agence successfully create', 'product.index');
        }

        return $this->render('product/addProduct.html.twig', [
            'products' => $products,
            'formAddProduct' => $form->createView(),

        ]);
    }
}

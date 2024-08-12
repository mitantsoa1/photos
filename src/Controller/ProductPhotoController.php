<?php

namespace App\Controller;

use App\Controller\admin\BaseController;
use App\Entity\Product;
use App\Entity\ProductPhotos;
use App\Form\ProductPhotosType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductPhotoController extends BaseController
{
    #[Route('/product/{id}/addPhoto', name: 'add_product_photo')]
    public function index(Request $request, int $id): Response
    {
        // $photos = new photos();
        $photos = new ProductPhotos();

        $product = $product = $this->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductPhotosType::class, $photos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('filename')->getData();
            $filename = $file->getClientOriginalName();
            $dirPhotos = $this->getParameter('kernel.project_dir') . "/public/images/products/$id";

            if ($file->move($dirPhotos, $filename)) {
                $photos->setFilename($filename);
                $photos->setProductId($product);
                $this->save($photos);
                $this->addFlash('success', 'Photos successfully add');

                return $this->redirectToRoute('product.show', ['id' => $id]);
            }
        }

        return $this->render('product/addPhoto.html.twig', [
            'formAddPhotos' => $form,
            'product' => $product
        ]);
    }
}
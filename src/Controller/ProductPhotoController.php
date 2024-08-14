<?php

namespace App\Controller;

use App\Controller\admin\BaseController;
use App\Entity\Product;
use App\Entity\ProductPhotos;
use App\Form\ProductPhotosType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\Proxy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductPhotoController extends BaseController
{
    #[Route('/product/{idProduct}/add', name: 'add_product_photo')]
    #[Route('/product/{idProduct}/edit/{id}', name: 'edit_product_photo')]
    public function index(Request $request, int $idProduct, ProductPhotos $photos = null): Response
    {

        if (!$photos) $photos = new ProductPhotos();

        $product = $this->getRepository(Product::class)->find($idProduct);


        if ($product instanceof Proxy) {
            $product->__load(); // Charge toutes les propriétés de l'objet proxy 
            /**
             * au lieu de
             * // $product->getName(); // Force Doctrine à charger le nom
             * // $product->getPrice(); // Force Doctrine à charger le prix
             * 
             */
        }

        $form = $this->createForm(ProductPhotosType::class, $photos);

        $form->handleRequest($request);

        // dd($product, $photos, $form);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('filename')->getData();

            $filename = $file->getClientOriginalName();
            $dirPhotos = $this->getParameter('kernel.project_dir') . "/public/asset/images/products";

            if ($file->move($dirPhotos, $filename)) {
                $photos->setFilename($filename);
                $photos->setProductId($product);
                $this->save($photos);
                $this->addFlash('success', 'Photos successfully add');

                return $this->redirectToRoute('product.show', ['id' => $idProduct]);
            }
        }

        return $this->render('product/addPhoto.html.twig', [
            'formAddPhotos' => $form,
            'product' => $product,
            "edit_mode"  => $photos->getId() != null,
            "photo" => $photos
        ]);
    }

    #[Route('/product/{idProduct}/delete/{id}', name: 'delete_product_photo')]
    public function delete(ProductPhotos $photos, int $idProduct): Response
    {

        if ($this->remove($photos)) {
            $this->addFlash('success', 'Photos successfully deleted');

            return $this->redirectToRoute('product.show', ['id' => $idProduct]);
        }
        $this->addFlash('error', 'An error has encured');

        return $this->redirectToRoute('product.show', ['id' => $idProduct]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product")
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

	public function show2($id, ProductRepository $productRepository)
	{
    	$product = $productRepository->find($id);

		if (!$product) {
			throw $this->createNotFoundException('Product #'. $id . ' not found');
		}

		return $this->render('product/show.html.twig', [
			'product' => $product,
		]);
	}
}

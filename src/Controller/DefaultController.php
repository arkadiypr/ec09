<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
	/**
	 * @Route("/", name="default")
	 */
	public function index(ProductRepository $productRepository)
	{
		$products = $productRepository->findBy(
			['isTop' => true],
			['name' => 'ASC']
		);

		return $this->render('default/index.html.twig',
			[
				'products' => $products,
			]);
	}

}
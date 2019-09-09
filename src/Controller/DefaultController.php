<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
	/**
	 * @Route("/", name="default")
	 */
	public function index()
	{
		$message = 'I\'m index method!';

		return $this->render('default/index.html.twig',
			[
				'mess' => $message,
			]);
	}

}
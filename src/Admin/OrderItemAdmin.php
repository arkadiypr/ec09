<?php

namespace App\Admin;


use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class OrderItemAdmin extends AbstractAdmin
{
	public function configureFormFields(FormMapper $form)
	{
		$form
			->add('product')
			->add('price', null,
				[
					'attr' => [
						'readonly' => true
					]
				])
			->add('count')
//			->add('amount')
			;

		$form->get('price')->addModelTransformer(new MoneyTransformer());

	}

}
<?php

namespace App\Admin;

use App\Form\MoneyTransformer;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;


class OrderAdmin extends AbstractAdmin
{
	protected function configureListFields(ListMapper $list)
	{
		$list->addIdentifier('id')
			->addIdentifier('orderedAt')
			->addIdentifier('firstName')
			->addIdentifier('lastName')
			->addIdentifier('email')
			->add('amount', null, [
				'template' => 'admin/order/_list_amount.html.twig'
			]);
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter->add('id')
			->add('orderedAt')
			->add('firstName')
			->add('lastName')
			->add('email')
			->add('amount');
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form->add('orderedAt')
			->add('firstName')
			->add('lastName')
			->add('email')
			->add('address')
			->add('amount')
		    ->add('items',
				CollectionType::class,
				[
					'by_reference' => false
				],
				[
					'edit' => 'inline',
					'inline' => 'table'
				]);

		$form->get('amount')->addModelTransformer(new MoneyTransformer());
	}

	public function createQuery($context = 'list')
	{
		/**
		 * @var QueryBuilder $query
		 */
		$query = parent::createQuery($context);
		list($rootAlias) = $query->getRootAliases();

		$query->andWhere($rootAlias . '.orderedAt IS NOT NULL');

		return $query;
	}


}
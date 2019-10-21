<?php

namespace App\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class OrderAdmin extends AbstractAdmin
{
	protected function configureListFields(ListMapper $list)
	{
		$list->addIdentifier('id')
			->addIdentifier('orderedAt')
			->addIdentifier('firstName')
			->addIdentifier('lastName')
			->addIdentifier('email')
			->addIdentifier('amount');
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
			->add('amount');;
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
<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin
{
	protected function configureListFields(ListMapper $list)
	{
		$list->addIdentifier('id')
			->addIdentifier('name')
			->addIdentifier('price')
			->addIdentifier('description')
			->addIdentifier('isTop');

	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter->add('id')
			->add('name')
			->add('price')
			->add('description')
			->add('isTop');
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form->add('name')
			->add('price')
			->add('description')
			->add('isTop');
	}

}
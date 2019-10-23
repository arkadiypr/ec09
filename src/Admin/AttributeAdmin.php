<?php

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AttributeAdmin extends AbstractAdmin
{
	protected function configureListFields(ListMapper $list)
	{
		$list
			->addIdentifier('category')
			->addIdentifier('name');
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter
			->add('category')
			->add('name');
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form
			->add('category')
			->add('name')
			->add('valuesList');
	}


}
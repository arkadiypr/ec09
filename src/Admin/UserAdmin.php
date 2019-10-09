<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
	protected function configureListFields(ListMapper $list)
	{
		$list->addIdentifier('id')
			->addIdentifier('email')
			->addIdentifier('roles')
			->addIdentifier('firstName')
			->addIdentifier('lastName')
			;
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter->add('email')
			->add('roles', null, [], ChoiceType::class, [
				'choices' => [
					'Пользователь' => 'ROLE_USER',
					'Администратор' => 'ROLE_ADMIN'
				],
			])
			->add('firstName')
			->add('lastName')
		;
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form->add('email')
			->add('roles', ChoiceType::class, [
				'choices' => [
					'Пользователь' => 'ROLE_USER',
					'Администратор' => 'ROLE_ADMIN'
				],
				'multiple' => true,
				'expanded' => true
			])
			->add('plainPassword', TextType::class,
				[
					'required' => false
				])
			->add('firstName')
			->add('lastName')
			->add('address', null,
				[
					'required' => false
				])
		;
	}


}
<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:53
 */

namespace App\ISModule\Presenters;

use Nette;
use App\ISModule\Model;
use Tracy\Debugger;
use App\ISModule\Forms;


class UsersPresenter extends SecuredPresenter
{
	/** @var Forms\UserFormFactory @inject */
	public $userFormFactory;

	/** @var Model\UserManager @inject */
	public $userManager;

	public function actionEdit( $id ) {
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentAddUser() {
		$em          = $this->entityManager;
		$userManager = $this->userManager;

		/** @var $em \Kdyby\Doctrine\EntityManager */
		return $this->userFormFactory->create( function ( Nette\Application\UI\Form $form, $values ) use ( $em, $userManager ) {
			$contact = null;
			try {
				$contact = $userManager->add( $values->username, $values->password, $values->role );
			} catch ( Model\DuplicateNameException $e ) {
				$form->addError( 'forms.user.errorDuplicateName' );
			}
			$contact->setCity( $values->city );
			$contact->setStreet( $values->street );
			$contact->setHouseNumber( $values->houseNumber );
			$contact->setPhone( $values->phone );
			$contact->setEmail( $values->email );

			$this->redirect( 'Users:edit ' . $values->username );
		} );
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentEditUser() {
		$em          = $this->entityManager;
		$userManager = $this->userManager;

		/** @var $em \Kdyby\Doctrine\EntityManager */
		return $this->userFormFactory->create( function ( Nette\Application\UI\Form $form, $values ) use ( $em, $userManager ) {
			$contact = null;
			//$em->getRepository(Model\User::class)->findOneById();
			$contact->setCity( $values->city );
			$contact->setStreet( $values->street );
			$contact->setHouseNumber( $values->houseNumber );
			$contact->setPhone( $values->phone );
			$contact->setEmail( $values->email );

			$this->redirect( 'Users:edit ' . $values->username );
		} );
	}
}
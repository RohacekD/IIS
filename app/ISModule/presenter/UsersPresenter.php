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
		$database    = $this->database;
		$userManager = $this->userManager;

		return $this->userFormFactory->create( function ( Nette\Application\UI\Form $form, $values ) use ( $database, $userManager ) {
			$contactId = null;
			try {
				$contactId = $userManager->add( $values->username, $values->password, $values->role );
			} catch ( Model\DuplicateNameException $e ) {
				$form->addError( 'forms.user.errorDuplicateName' );
			}
			$database->table( "Kontakt" )->where( [
				'ID' => $contactId
			] )->update( [
				'mesto'   => $values->city,
				'ulice'   => $values->street,
				'cp'      => $values->houseNumber,
				'telefon' => $values->phone,
				'email'   => $values->email,
			] );

			$this->redirect( 'Users:edit ' . $values->username );
		} );
	}
}
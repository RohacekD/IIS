<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:53
 */

namespace App\ISModule\Presenters;

use Nette;
use Ublaboo\DataGrid\DataGrid;
use Nette\Security\Passwords;
use App\ISModule\Model;
use App\ISModule\Forms;


class UsersPresenter extends SecuredPresenter {
	/** @var Forms\UserFormFactory @inject */
	public $userFormFactory;
	/** @var Model\UserManager @inject */
	public $userManager;
	/**
	 * @var @persistent Nette\Database\Table\Selection
	 */
	private $gridDataSource;
	/**
	 * @var Model\User
	 */
	private $user;

	public function actionEdit( $id ) {
		$this->user = $this->getEm()->getRepository( Model\User::class )->findOneById( $id );
	}

	public function actionList() {
		$this->gridDataSource = $this->getEm()->createQueryBuilder()
		                             ->select( 'user' )
		                             ->from( Model\User::class, 'user' );
	}

	public function createComponentListGrid( $name ) {
		$grid = $this->makeGrid( $name );
		$grid->setTemplateFile( __DIR__ . '/templates/Users/my-grid-detail.latte' );

		return $grid;
	}

	/**
	 * @param $name
	 *
	 * @return DataGrid
	 */
	private function makeGrid( $name ) {
		$grid = new DataGrid( $this, $name );

		$source = $this->gridDataSource;
		$grid->setPrimaryKey( "id" );
		$grid->setTranslator( $this->translator );
		$grid->setDataSource( $source );

		$presenter = $this;

		$grid->addColumnText( 'username', 'Přihlašovací jméno' );
		$grid->addColumnText( 'sir_name', 'Jméno' );
		$grid->addColumnText( 'last_name', 'Příjmení' );
		$grid->addColumnText( 'sex', 'Pohlaví' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete role \'%s\'?', 'username' );
		$grid->addActionCallback( "edit", "" )
		     ->setIcon( 'pencil' )
		     ->setTitle( 'Upravit' )
		     ->setClass( 'btn btn-xs btn-warning ajax' )
			->onClick[] = function ( $item_id ) use ( $presenter ) {
			$presenter->redirect( "Users:edit", [ $item_id ] );
		};;

		return $grid;
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
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
				$user = $userManager->add( $values->username, $values->password, $values->role );
			} catch ( Model\DuplicateNameException $e ) {
				$form->addError( 'forms.user.errorDuplicateName' );

				return;
			}
			$user->setSex( $values->sex );
			$user->setSirName( $values->sir_name );
			$user->setLastName( $values->last_name );
			$contact = $user->getContact();
			$contact->setCity( $values->city );
			$contact->setStreet( $values->street );
			$contact->setHouseNumber( $values->houseNumber );
			$contact->setPhone( $values->phone );
			$contact->setEmail( $values->email );

			$em->persist( $user );
			$em->persist( $contact );
			$em->flush();

			$this->redirect( 'Users:edit', [ $em->getRepository( Model\User::class )->findOneByUsername( $values->username )->getId() ] );
		}, new Model\User() );
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentEditUser() {
		$em          = $this->entityManager;
		$userManager = $this->userManager;
		$user = $this->user;

		/** @var $em \Kdyby\Doctrine\EntityManager */
		return $this->userFormFactory->create( function ( Nette\Application\UI\Form $form, $values ) use ( $em, $userManager, $user ) {
			$contact = $user->getContact();
			$user->setUsername( $values->username );

			if ( $values->password ) {
				if ( $values->password != $values->passwordAgain ) {
					$form->addError( "Heslo nezměněno. Neshodvalay se!" );
				} else {
					$user->setPassword( Passwords::hash( $values->password ) );
				}
			}
			$user->setRole( $values->role );
			$user->setSex( $values->sex );
			$user->setSirName( $values->sir_name );
			$user->setLastName( $values->last_name );

			$contact->setCity( $values->city );
			$contact->setStreet( $values->street );
			$contact->setHouseNumber( $values->houseNumber );
			$contact->setPhone( $values->phone );
			$contact->setEmail( $values->email );


			try {
				$em->persist( $contact );
				$em->persist( $user );
				$em->flush();
			} catch ( Model\DuplicateNameException $e ) {
				$form->addError( 'forms.user.errorDuplicateName' );

				return;
			}

			$this->redirect( 'Users:edit', [ $em->getRepository( Model\User::class )->findOneByUsername( $values->username )->getId() ] );

		}, $this->user );
	}
}
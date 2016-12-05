<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.12.2016
 * Time: 9:16
 */

namespace App\ISModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Forms\FormFactory;
use App\ISModule\Model;
use Tracy\Debugger;

class UserFormFactory {
	use Nette\SmartObject;

	/** @var Model\UserManager @inject */
	public $userManager;
	/** @var FormFactory */
	private $factory;
	/** @var User */
	private $user;

	/**
	 * @param FormFactory $factory
	 * @param User $user
	 */
	public function __construct( FormFactory $factory, User $user ) {
		$this->factory = $factory;
		$this->user    = $user;
	}


	/**
	 * @param callable $onSuccess
	 * @param Model\User $user
	 *
	 * @return Form
	 */
	public function create( callable $onSuccess, Model\User $user ) {
		$form = $this->factory->create();
		$form->elementPrototype->addAttributes( array( 'class' => 'form-user' ) );
		$form->addText( 'username' )
		     ->setRequired( 'forms.user.usernameHint' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setAttribute( 'placeholder', 'forms.user.username' )
		     ->setDefaultValue( $user->getUsername() );

		$form->addSelect( "role", null,
			[
				'director'  => 'forms.users.role.director',
				'actor'     => 'forms.users.role.actor',
				'organizer' => 'forms.users.role.organizer'
			] )
		     ->setRequired( 'forms.user.roleHint' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setDefaultValue( $user->getRole() );

		$form->addSelect( "sex", null,
			[
				'male'   => 'Muž',
				'female' => 'Žena',
			] )
		     ->setRequired( 'Pohlaví' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setDefaultValue( $user->getSex() );

		if ( $user->getId() ) {

			$form->addPassword( 'password' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.password' );

			$form->addPassword( 'passwordAgain' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.passwordAgain' );
		} else {

			$form->addPassword( 'password' )
			     ->setRequired( 'forms.user.passwordHint' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.password' );

			$form->addPassword( 'passwordAgain' )
			     ->setRequired( 'forms.user.passwordAgainHint' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.passwordAgain' );
		}


		$form->addText( 'sir_name' )
		     ->setRequired( 'forms.user.passwordHint' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setAttribute( 'placeholder', 'Jméno' )
		     ->setDefaultValue( $user->getSirName() );


		$form->addText( 'last_name' )
		     ->setRequired( 'forms.user.passwordHint' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setAttribute( 'placeholder', 'Příjmení' )
		     ->setDefaultValue( $user->getLastName() );

		if ( $user->getId() ) {
			$form->addText( 'city' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.city' )
			     ->setDefaultValue( $user->getContact()->getCity() );

			$form->addText( 'street' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.street' )
			     ->setDefaultValue( $user->getContact()->getStreet() );

			$form->addText( 'houseNumber' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.houseNumber' )
			     ->setDefaultValue( $user->getContact()->getHouseNumber() );

			$form->addText( 'phone' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'type', 'tel' )
			     ->setAttribute( 'placeholder', 'forms.user.phone' )
			     ->setDefaultValue( $user->getContact()->getPhone() );

			$form->addEmail( 'email' )
			     ->setRequired( 'forms.user.emailHint' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.email' )
			     ->setDefaultValue( $user->getContact()->getEmail() );
		} else {
			$form->addText( 'city' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.city' );

			$form->addText( 'street' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.street' );

			$form->addText( 'houseNumber' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.houseNumber' );

			$form->addText( 'phone' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'type', 'tel' )
			     ->setAttribute( 'placeholder', 'forms.user.phone' );

			$form->addEmail( 'email' )
			     ->setRequired( 'forms.user.emailHint' )
			     ->setAttribute( 'class', 'form-control' )
			     ->setAttribute( 'placeholder', 'forms.user.email' );
		}

		$form->addSubmit( 'send', 'forms.user.create' )
		     ->setAttribute( 'class', 'btn btn-lg btn-primary btn-block' );


		$userManager = $this->userManager;

		$form->onSuccess[] = function ( Form $form, $values ) use ( $onSuccess, $userManager ) {
			if ( $values->password != $values->passwordAgain ) {
				$form->addError( 'forms.user.errorPassword' );
			}
			$onSuccess( $form, $values );
		};

		return $form;
	}


}
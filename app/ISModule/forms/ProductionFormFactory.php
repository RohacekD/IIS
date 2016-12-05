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
use \Kdyby\Doctrine;

class ProductionFormFactory {
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;
	/**
	 * @var \Kdyby\Doctrine\EntityManager
	 */
	private $em;

	/**
	 * ProductionFormFactory constructor.
	 *
	 * @param FormFactory $factory
	 * @param \Kdyby\Doctrine\EntityManager $em
	 */
	public function __construct( FormFactory $factory, \Kdyby\Doctrine\EntityManager $em ) {
		$this->factory = $factory;
		$this->em      = $em;
	}


	/**
	 * @param callable $onSuccess
	 * @param Model\Production $production
	 *
	 * @return Form
	 */
	public function create( callable $onSuccess, Model\Production $production ) {
		$form = $this->factory->create();
		$form->elementPrototype->addAttributes( array( 'class' => 'form-user' ) );

		$plays     = array();
		$directors = array();

		foreach (
			$this->em->createQueryBuilder()
			         ->select( 'play.id, play.name' )
			         ->from( Model\Play::class, 'play' )->getQuery()->getResult( 2 ) as $item
		) {
			$plays[ $item["id"] ] = $item["name"];
		}

		foreach (
			$this->em->createQueryBuilder()
			         ->select( 'user.id, user.username' )
			         ->from( Model\User::class, 'user' )
			         ->where( 'user.role = :director' )
			         ->setParameter( 'director', "director" )
			         ->getQuery()->getResult( 2 ) as $item
		) {
			$directors[ $item["id"] ] = $item["username"];
		}

		if ( $production->getId() ) {

			$form->addSelect( "play", null, $plays )
			     ->setRequired( 'forms.user.roleHint' )
			     ->setAttribute( 'data-live-search', 'true' )
			     ->setAttribute( 'class', 'form-control selectpicker' )
			     ->setDefaultValue( $production->getPlay()->getId() );
			$form->addSelect( "director", null, $directors )
			     ->setRequired( 'forms.user.roleHint' )
			     ->setAttribute( 'data-live-search', 'true' )
			     ->setAttribute( 'class', 'form-control selectpicker' )
			     ->setDefaultValue( $production->getDirector()->getId() );
		} else {
			$form->addSelect( "play", null, $plays )
			     ->setRequired( 'forms.user.roleHint' )
			     ->setAttribute( 'data-live-search', 'true' )
			     ->setAttribute( 'class', 'form-control selectpicker' );
			$form->addSelect( "director", null, $directors )
			     ->setRequired( 'forms.user.roleHint' )
			     ->setAttribute( 'data-live-search', 'true' )
			     ->setAttribute( 'class', 'form-control selectpicker' );
		}

		$form->addSelect( "scene", null,
			[ "big" => "Velká", "small" => "Malá" ] )
		     ->setRequired( 'forms.user.roleHint' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setDefaultValue( $production->getScene() );

		/*$form->addMultiSelect( 'options', 'Možnosti:', [
			'director'  => 'herec 1',
			'actor'     => 'herec  2',
			'organizer' => 'herec 3'
		] )
		     ->setRequired( 'forms.user.roleHint' )
		     ->setAttribute( 'class', 'form-control selectpicker' )
		     ->setAttribute( 'placeholder', 'forms.rehearsal.production' );*/

		$form->addText( 'date' )
		     ->setAttribute( "type", "datetime-local" )
		     ->setRequired( 'forms.rehearsal.hintProduction' )
		     ->setAttribute( 'class', 'form-control' )
		     ->setAttribute( 'placeholder', 'forms.rehearsal.date' );


		$form->addSubmit( 'send', 'forms.user.create' )
		     ->setAttribute( 'class', 'btn btn-lg btn-primary btn-block' );


		$form->onSuccess[] = function ( Form $form, $values ) use ( $onSuccess ) {
			$onSuccess( $form, $values );
		};

		return $form;
	}


}
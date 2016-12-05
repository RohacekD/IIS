<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:01
 */

namespace App\ISModule\Presenters;

use App\ISModule\Forms;
use App\ISModule\Model;
use Nette;
use Tracy\Debugger;


class PlaysPresenter extends SecuredPresenter {
	/** @var Forms\PlayFormFactory @inject */
	public $playFormFactory;

	/**
	 * @var Model\Play
	 */
	private $play;

	public function actionAdd() {
		$this->play = new Model\Play;
	}

	public function actionEdit( $id ) {
		$this->play = $this->getEm()->getRepository( Model\Play::class )->findOneById( $id );
	}

	protected function createComponentAddPlay() {
		$em   = $this->entityManager;
		$play = $this->play;

		return $this->playFormFactory->create( function ( Nette\Application\UI\Form $form, $values ) use ( $em, $play ) {
			$play->setAuthor( $values->author );
			$play->setDescription( $values->author );
			$play->setTimeNeeded( new \DateTime( $values->time ) );
			$play->setName( $values->name );
			$play->setPhoto( "cesta_co_nikam_nepovede" );
			$em->persist( $play );
			$em->flush();
			$this->redirect( 'Plays:edit', [ $play->getId() ] );

		}, $this->play );
    }
}
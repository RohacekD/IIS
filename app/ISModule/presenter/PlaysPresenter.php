<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:01
 */

namespace App\ISModule\Presenters;

use Ublaboo\DataGrid\DataGrid;
use App\ISModule\Forms;
use App\ISModule\Model;
use Nette;


class PlaysPresenter extends SecuredPresenter {
	/** @var Forms\PlayFormFactory @inject */
	public $playFormFactory;

	/**
	 * @var Model\Play
	 */
	private $play;
	/**
	 * @var @persistent Nette\Database\Table\Selection
	 */
	private $gridDataSource;

	public function actionAdd() {
		$this->play = new Model\Play;
	}

	public function actionEdit( $id ) {
		$this->play = $this->getEm()->getRepository( Model\Play::class )->findOneById( $id );
	}


	public function actionList() {
		$this->gridDataSource = $this->getEm()->createQueryBuilder()
		                             ->select( 'play' )
		                             ->from( Model\Play::class, 'play' );
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

		$grid->addColumnText( 'name', 'Název' );
		$grid->addColumnText( 'author', 'Autor' );
		$grid->addColumnDateTime( 'timeNeeded', 'Čas k nastudování' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete role \'%s\'?', 'name' );
		$grid->addActionCallback( "edit", "" )
		     ->setIcon( 'pencil' )
		     ->setTitle( 'Upravit' )
		     ->setClass( 'btn btn-xs btn-warning ajax' )
			->onClick[] = function ( $item_id ) use ( $presenter ) {
			$presenter->redirect( "Plays:edit", [ $item_id ] );
		};;

		return $grid;
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
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
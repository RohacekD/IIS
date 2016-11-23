<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:56
 */

namespace App\ISModule\Presenters;


use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;
use Nette;

/**
 * Class PerformancesPresenter
 * @package App\ISModule\Presenters
 *
 * @brief Means "predstaveni"
 */
class PerformancesPresenter extends SecuredPresenter {
	/**
	 * @var Nette\Database\Table\Selection
	 */
	private $gridDataSource;

	public function createComponentSimpleGrid( $name ) {
		$grid = new DataGrid( $this, $name );

		$source = $this->gridDataSource;
		$grid->setPrimaryKey( "ID" );
		$grid->setTranslator( $this->translator );
		$grid->setDataSource( $source );
		$grid->addColumnText( 'nazev', 'tables.productions.name' );
		$grid->addColumnText( 'scena', 'tables.productions.scene' );
		$grid->addColumnText( 'login_Reziser', 'tables.productions.director' );
		$grid->addColumnDateTime( 'Datum', 'tables.productions.date' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete example %s?', 'Datum' );

		$grid->setItemsDetail();
	}

	public function renderMy() {
		$this->gridDataSource = $this->database->table( "Predstaveni" )->select( "Predstaveni.ID, Datum, 
		Inscenace.nazev, Inscenace.scena, Inscenace.login_Reziser" );
	}

	public function handleDelete( $id ) {
		Debugger::dump( $id );
	}
}
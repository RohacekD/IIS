<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:52
 */

namespace App\ISModule\Presenters;

use Ublaboo\DataGrid\DataGrid;

/**
 * Class ProductionsPresenter
 * @package App\ISModule\Presenters
 * @brief Means "inscenace"
 */
class ProductionsPresenter extends SecuredPresenter
{
	const PRODUCTION_TABLE = "Inscenace";
	const PLAYS_TABLE = "Divadelni_hra";
	/**
	 * @var @persistent Nette\Database\Table\Selection
	 */
	private $gridDataSource;

	public function createComponentMyGrid( $name ) {
		$grid = $this->makeGrid( $name );
		$grid->setTemplateFile( __DIR__ . '/templates/Productions/my-grid-detail.latte' );

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
		$grid->setPrimaryKey( "ID" );
		$grid->setTranslator( $this->translator );
		$grid->setDataSource( $source );

		$grid->addColumnText( 'nazev', 'tables.productions.name' );
		$grid->addColumnText( 'scena', 'tables.productions.scene' );
		$grid->addColumnText( 'login_Reziser', 'tables.productions.director' );
		$grid->addColumnText( 'autor', 'tables.productions.author' );
		//$grid->addColumnDateTime( 'casova_narocnost', 'tables.productions.timeDifficulty' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete production \'%s\'?', 'nazev' );

		$grid->setItemsDetail( true, self::PRODUCTION_TABLE . ".ID" );

		return $grid;
	}

	public function actionMy() {
		//todo
		$this->gridDataSource = $this->database->table( self::PRODUCTION_TABLE )
		                                       ->select( self::PRODUCTION_TABLE . ".ID, "
		                                                 . self::PRODUCTION_TABLE . ".nazev, "
		                                                 . self::PRODUCTION_TABLE . ".scena, "
		                                                 . self::PRODUCTION_TABLE . ".login_Reziser, "
		                                                 . self::PLAYS_TABLE . ".popis, "
		                                                 . self::PLAYS_TABLE . ".jmeno, "
		                                                 . self::PLAYS_TABLE . ".fotka, "
		                                                 . self::PLAYS_TABLE . ".casova_narocnost, "
		                                                 . self::PLAYS_TABLE . ".autor " );
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
	}
}
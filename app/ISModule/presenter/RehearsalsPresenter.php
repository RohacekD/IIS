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
 * Class RehearsalsPresenter
 * @package App\ISModule\Presenters
 * @brief Means "zkousky"
 */
class RehearsalsPresenter extends SecuredPresenter {
	/**
	 * @var @persistent Nette\Database\Table\Selection
	 */
	private $gridDataSource;

	public function createComponentMyPerformancesGrid( $name ) {
		$grid = $this->makeGrid( $name );
		$grid->setTemplateFile( __DIR__ . '/templates/Rehearsals/my-grid-detail.latte' );

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

		$grid->addColumnText( 'nazev', 'tables.performances.name' );
		$grid->addColumnText( 'scena', 'tables.performances.scene' );
		$grid->addColumnText( 'login_Reziser', 'tables.performances.director' );
		$grid->addColumnDateTime( 'Datum', 'tables.performances.date' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete performance \'%s\'?', 'nazev' );

		$grid->setItemsDetail( true, "Predstaveni.ID" );

		return $grid;
	}

	public function actionMy() {
		//todo jen ta kde hraji
		$this->gridDataSource = $this->database
			->query( "
				SELECT `Zkouska`.*
				FROM `Zkouska` 
				LEFT JOIN `Inscenace` ON `Zkouska`.`Inscenace_ID` = `Inscenace`.`ID`
				LEFT JOIN `Inscenace_Herec` ON `Inscenace`.`ID` = `Inscenace_Herec`.`ID_Inscenace`
				WHERE (`Inscenace_Herec`.`login_Herec` = '" . $this->getUser()->getId() . "') 
				ORDER BY `Zkouska`.`Datum`" );
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//TODO
	}
}
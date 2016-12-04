<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:55
 */

namespace App\ISModule\Presenters;

use Ublaboo\DataGrid\DataGrid;


class RolePresenter extends SecuredPresenter {
	const PRODUCTION_TABLE = "Inscenace";
	const PLAYS_TABLE = "Divadelni_hra";
	const ROLES_TABLE = "Role";
	const ROLES_ACTOR_TABLE = "Role_Herec";
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

		$grid->addColumnText( 'nazev', 'tables.role.name' );
		$grid->addColumnText( 'obtiznost', 'tables.role.difficulty' );
		$grid->addColumnText( 'casova_narocnost', 'tables.productions.timeDifficulty' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete role \'%s\'?', 'nazev' );

		$grid->setItemsDetail( true, self::ROLES_TABLE . ".ID" );

		return $grid;
	}

	public function actionMy() {
		$this->gridDataSource = $this->
		database->table( self::ROLES_ACTOR_TABLE )
			//->joinWhere( self::PRODUCTION_TABLE, self::ROLES_TABLE . ".ID_inscenace = " . self::PRODUCTION_TABLE . ".ID" )
		        ->select( self::ROLES_TABLE . ".ID,"
		                  . self::ROLES_TABLE . ".nazev, "
		                  . self::ROLES_TABLE . ".obtiznost, "
		                  . self::ROLES_TABLE . ".casova_narocnost, "
		                  . self::ROLES_TABLE . ".popis,"
			/* . self::PRODUCTION_TABLE . ".nazev" */ )
		        ->where( self::ROLES_ACTOR_TABLE . ".login_Herec ", $this->getUser()->getId() );
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
	}
}
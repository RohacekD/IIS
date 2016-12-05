<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:55
 */

namespace App\ISModule\Presenters;

use Ublaboo\DataGrid\DataGrid;
use App\ISModule\Model;

class RolePresenter extends SecuredPresenter {
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
		$grid->setPrimaryKey( "id" );
		$grid->setTranslator( $this->translator );
		$grid->setDataSource( $source );

		$grid->addColumnText( 'name', 'tables.role.name' );
		$grid->addColumnText( 'difficulty', 'tables.role.difficulty' );
		$grid->addColumnText( 'time_difficulty', 'tables.productions.timeDifficulty' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete role \'%s\'?', 'name' );

		$grid->setItemsDetail( true, "role.ID" );

		return $grid;
	}

	public function actionMy() {
		$this->gridDataSource = $this->getEm()->createQueryBuilder()
		                             ->select( 'role' )
		                             ->from( Model\Performance::class, 'role' )
		                             ->join( 'role.actors', 'u' )
		                             ->where( 'u.id = :user' )
		                             ->setParameter( 'user', $this->getUser()->getId() );
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
	}
}
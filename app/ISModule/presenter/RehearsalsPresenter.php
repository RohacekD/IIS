<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:52
 */

namespace App\ISModule\Presenters;

use Ublaboo\DataGrid\DataGrid;
use App\ISModule\Forms;
use App\ISModule\Model;
/**
 * Class RehearsalsPresenter
 * @package App\ISModule\Presenters
 * @brief Means "zkousky"
 */
class RehearsalsPresenter extends SecuredPresenter {
    /** @var Forms\RehearsalFormFactory @inject */
    public $rehearsalFormFactory;
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
		$grid->setPrimaryKey( "id" );
		$grid->setTranslator( $this->translator );
		$grid->setDataSource( $source );

		$grid->addColumnText( 'production.name', 'tables.performances.name' );
		$grid->addColumnText( 'production.scene', 'tables.performances.scene' );
		$grid->addColumnText( 'production.director.username', 'tables.performances.director' );
		$grid->addColumnDateTime( 'date', 'tables.performances.date' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete performance \'%s\'?', 'production.name' );

		$grid->setItemsDetail( true, "r.id" );

		return $grid;
	}

	public function actionMy() {
		$this->gridDataSource = $this->getEm()->createQueryBuilder()
		                             ->select( 'r, pro' )
		                             ->from( Model\Rehearsal::class, 'r' )
		                             ->leftJoin( 'r.production', 'pro' )
		                             ->join( 'pro.roles', 'roles' )
		                             ->join( 'roles.actors', 'u' )
		                             ->where( 'u.id = :user' )
		                             ->setParameter( 'user', $this->getUser()->getId() );
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//TODO
	}

    protected function createComponentAddRehearsal()
    {

        return $this->rehearsalFormFactory->create(function () {

        });
    }
}
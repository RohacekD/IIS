<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:52
 */

namespace App\ISModule\Presenters;

use App\ISModule\Model;
use Ublaboo\DataGrid\DataGrid;
use App\ISModule\Forms;

/**
 * Class ProductionsPresenter
 * @package App\ISModule\Presenters
 * @brief Means "inscenace"
 */
class ProductionsPresenter extends SecuredPresenter
{
    /** @var Forms\ProductionFormFactory @inject */
    public $productionFormFactory;

    protected function createComponentAddProduction()
    {

        return $this->productionFormFactory->create(function () {
        });
    }

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
		$grid->setPrimaryKey( "id" );
		$grid->setTranslator( $this->translator );
		$grid->setDataSource( $source );

		$grid->addColumnText( 'name', 'tables.productions.name' );
		$grid->addColumnText( 'scene', 'tables.productions.scene' );
		$grid->addColumnText( 'director.username', 'tables.productions.director' );
		$grid->addColumnText( 'play.author', 'tables.productions.author' );
		$grid->addColumnDateTime( 'play.time_needed', 'tables.productions.timeDifficulty' );
		$grid->addAction( "delete", "", "delete!" )
		     ->setIcon( 'trash' )
		     ->setTitle( 'Delete' )
		     ->setClass( 'btn btn-xs btn-danger ajax' )
		     ->setConfirm( 'Do you really want to delete production \'%s\'?', 'name' );

		$grid->setItemsDetail( true, "pro.id" );

		return $grid;
	}

	public function actionMy() {
		$this->gridDataSource = $this->getEm()->createQueryBuilder()
		                             ->select( 'pro, play' )
		                             ->from( Model\Production::class, 'pro' )
		                             ->join( 'pro.play', 'play' )
		                             ->join( 'pro.roles', 'roles' )
		                             ->join( 'roles.actors', 'u' )
		                             ->where( 'u.id = :user' )
		                             ->setParameter( 'user', $this->getUser()->getId() );

	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
	}
}
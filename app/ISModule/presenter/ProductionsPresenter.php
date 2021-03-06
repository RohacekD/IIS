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
use App;

/**
 * Class ProductionsPresenter
 * @package App\ISModule\Presenters
 * @brief Means "inscenace"
 */
class ProductionsPresenter extends SecuredPresenter {
	/** @var Forms\ProductionFormFactory @inject */
	public $productionFormFactory;
	/**
	 * @var @persistent Nette\Database\Table\Selection
	 */
	private $gridDataSource;

	/**
	 * @var Model\Production
	 */
	private $production;

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

	public function createComponentListGrid( $name ) {
		$grid = $this->makeGrid( $name );
		$grid->setTemplateFile( __DIR__ . '/templates/Productions/my-grid-detail.latte' );

		return $grid;
	}

	public function createComponentAddRoles() {
		return new App\ISModule\Controls\AddRoleControl( $this->entityManager );
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

	public function actionList() {
		$this->gridDataSource = $this->getEm()->createQueryBuilder()
		                             ->select( 'pro, play' )
		                             ->from( Model\Production::class, 'pro' )
		                             ->join( 'pro.play', 'play' );
	}

	public function actionAdd() {
		$this->production = new Model\Production();
	}

	public function actionEdit( $id ) {
		$this->production = $this->getEm()->getRepository( Model\Production::class )->getOneById( $id );
	}

	public function handleDelete( $id ) {
		//Debugger::dump( $id );
		//todo
	}

	protected function createComponentAddProduction() {

		return $this->productionFormFactory->create( function () {
		}, $this->production );
	}
}
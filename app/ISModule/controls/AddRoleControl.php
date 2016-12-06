<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.12.2016
 * Time: 22:29
 */

namespace app\ISModule\controls;

use Kdyby\Doctrine\EntityManager,
	Nette\Application\UI\Control,
	App\ISModule\Model,
	Nette;

class AddRoleControl extends Control {
	/** @var EntityManager */
	protected $entityManager;

	/**
	 * @var int
	 */
	protected $productionId;

	/**
	 * PerformanceControl constructor.
	 *
	 * @param EntityManager $entityManager
	 */
	public function __construct( EntityManager $entityManager ) {
		parent::__construct();
		$this->entityManager = $entityManager;
	}


	/**
	 *
	 */
	public function render( $productionId ) {
		$this->productionId = $productionId;
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/AddRole.latte" );
		$this->template->roles = $this->getRoles();
		$this->template->render();
	}

	private function getRoles() {
		return $this->entityManager
			->createQueryBuilder()
			->select( 'role' )
			->from( Model\Role::class, 'role' )
			->join( 'role.production', 'production' )
			->where( 'production = :prod' )
			->getQuery()
			->setParameter( 'prod', $this->productionId );
	}
}
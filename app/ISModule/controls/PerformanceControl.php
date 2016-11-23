<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 23.11.2016
 * Time: 16:36
 */

namespace App\ISModule\Controls;

use Nette\Application\UI\Control,
	Nette;
use Tracy\Debugger;

/**
 * Class PerformanceControl
 * @package App\ISModule\Controls
 */
class PerformanceControl extends Control {
	/**
	 *
	 */
	const PERFORMANCE_TABLE = "Predstaveni",
		PRODUCTION_TABLE = "Inscenace",
		ACTOR_ROLES_TABLE = "Role_Herec",
		ROLE_TABLE = "Role",
		PLAY_TABLE = "Divadelni_hra";
	/**
	 * @var
	 */
	public $id;
	/**
	 * @var Nette\Security\Identity
	 */
	public $user;
	/** @var Nette\Database\Context */
	protected $database;

	/**
	 * PerformanceControl constructor.
	 *
	 * @param Nette\Security\IIdentity $user
	 * @param Nette\Database\Context $database
	 */
	public function __construct( Nette\Security\IIdentity $user, Nette\Database\Context $database ) {
		parent::__construct();
		$this->database = $database;
		$this->user     = $user;
	}

	/**
	 * Prepare data for rendering
	 */
	public function render( $id ) {
		$this->id = $id;
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/Performance.latte" );
		$this->template->performance = $this->getPerformance();
		$this->template->production  = $this->getProduction( $this->template->performance->ID );
		$this->template->play        = $this->getPlay( $this->template->production->ID_Divadelni_hra );
		$this->template->roles       = $this->getRoles( $this->template->production->ID );
		$this->template->render();
	}

	/**
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	private function getPerformance() {
		return $this->database->table( self::PERFORMANCE_TABLE )->where( "ID", $this->id )->fetch();
	}

	/**
	 * @param $id
	 *
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	private function getProduction( $id ) {
		return $this->database->table( self::PRODUCTION_TABLE )->where( "ID", $id )->fetch();
	}

	/**
	 * @param $id
	 *
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	private function getPlay( $id ) {
		return $this->database->table( self::PLAY_TABLE )->where( "ID", $id )->fetch();
	}

	/**
	 * @param $productionId
	 *
	 * @return array|Nette\Database\Table\IRow[]|Nette\Database\Table\Selection
	 */
	private function getRoles( $productionId ) {
		$actorsRoles = $this->database->table( self::ACTOR_ROLES_TABLE )->where( "LOGIN_HEREC", $this->user->getId() )->select( "ID_Role" )->fetchAll();
		$roles       = array();
		foreach ( $actorsRoles as $role ) {
			$roles[] = $role->ID_Role;
		}
		$rolesNames = $this->database->table( self::ROLE_TABLE )->where( [
			"ID"           => $roles,
			"ID_inscenace" => $productionId
		] )->fetchAll();

		return $rolesNames;
	}
}
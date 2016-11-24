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
		$this->template->play        = $this->getPlay( $this->template->performance->ID_Divadelni_hra );
		$this->template->roles       = $this->getRoles( $this->template->performance->ID_Inscenace );
		$this->template->render();
	}

	/**
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	private function getPerformance() {
		return $this->database->table( self::PERFORMANCE_TABLE )
		                      ->where( self::PERFORMANCE_TABLE . ".ID", $this->id )
		                      ->select( self::PERFORMANCE_TABLE . ".ID, " . self::PERFORMANCE_TABLE . ".Datum, "
		                                . self::PRODUCTION_TABLE . ".nazev, " . self::PRODUCTION_TABLE . ".ID_Divadelni_hra, "
		                                . self::PRODUCTION_TABLE . ".ID AS ID_Inscenace" )
		                      ->fetch();
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
		$rolesNames = $this->database
			->query( "SELECT ID, `nazev` 
					FROM `" . self::ROLE_TABLE . "` 
					WHERE (ID IN (SELECT `ID_Role` 
					FROM `" . self::ACTOR_ROLES_TABLE . "`
					WHERE (LOGIN_HEREC = '" . $this->user->getId() . "'))) 
					AND (`ID_inscenace` = " . $productionId . ")" )
			->fetchAll();

		return $rolesNames;
	}

	/**
	 * @param $id
	 *
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	private function getProduction( $id ) {
		return $this->database->table( self::PRODUCTION_TABLE )
		                      ->where( "ID", $id )
		                      ->fetch();
	}
}
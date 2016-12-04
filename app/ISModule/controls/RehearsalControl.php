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
class RehearsalControl extends Control {
	/**
	 *
	 */
	const PERFORMANCE_TABLE = "Predstaveni",
		PRODUCTION_TABLE = "Inscenace",
		ACTOR_ROLES_TABLE = "Role_Herec",
		ROLE_TABLE = "Role",
		PLAY_TABLE = "Divadelni_hra",
		REHEARSAL_TABLE = "Zkouska";
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
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/Rehearsal.latte" );
		$this->template->rehearsal = $this->getRehearsal();
		$this->template->render();
	}

	private function getRehearsal() {
		return $this->database->table( self::REHEARSAL_TABLE )
		                      ->where( self::REHEARSAL_TABLE . ".ID", $this->id )
		                      ->select( self::REHEARSAL_TABLE . ".ID, " . self::REHEARSAL_TABLE . ".Datum, "
		                                . self::REHEARSAL_TABLE . ".Zrusena, " . self::PRODUCTION_TABLE . ".nazev" )
		                      ->fetch();
	}
}
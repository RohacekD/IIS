<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 23.11.2016
 * Time: 14:33
 */

namespace App\ISModule\Controls;

use Nette\Application\UI\Control,
	Nette;
use Tracy\Debugger;

class MenuControl extends Control {
	/** @var Nette\Database\Context */
	protected $database;
	/** @var  Nette\Security\Identity */
	private $user;

	public function __construct( Nette\Security\Identity $user ) {
		parent::__construct();
		$this->user = $user;
	}

	public function injectDatabase( Nette\Database\Context $database ) {
		$this->database = $database;
	}

	public function render() {
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/Menu.latte" );
		$this->template->menuItems = $this->createMenu();
		$this->template->render();
	}

	/**
	 * @return array
	 */
	private function createMenu() {
		$return = array();
		if ( $this->user->getRoles()[0] == "actor" ) {
			$return = array(
				'Inscenace mé' => 'Productions:my',
				'Hry mé'       => 'Plays:my',
				'Role mé'      => 'Role:My',
				'Zkoušky mé'   => 'Rehearsals:my'
			);
		} elseif ( $this->user->getRoles()[0] == "director" ) {
			$return = array(
				'Hry'       => 'Plays:list',
				'Inscenace' => 'Productions:list',
				'Zkoušky'   => 'Rehearsals:list'
			);
		} elseif ( $this->user->getRoles()[0] == "organizer" ) {
			$return = array(
				'Představení' => 'Performanes:list',
				'Inscenace'   => 'Productions:list',
				'Hry'         => 'Plays:list',
				'Zkoušky'     => 'Rehearsals:list'
			);
		}

		return $return;
	}
}
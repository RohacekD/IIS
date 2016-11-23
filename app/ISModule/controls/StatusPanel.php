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

class StatusPanel extends Control {
	/** @var Nette\Database\Context */
	protected $database;
	/** @var Nette\Security\Identity */
	private $user;

	/**
	 * StatusPanel constructor.
	 *
	 * @param Nette\Security\Identity $user
	 * @param Nette\Database\Context $database
	 */
	public function __construct( Nette\Security\Identity $user, Nette\Database\Context $database ) {
		parent::__construct();
		$this->database = $database;
		$this->user     = $user;
	}

	/**
	 *
	 */
	public function render() {
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/StatusPanel.latte" );
		$this->template->user = $this->user;
		$this->template->render();
	}

	public function handleLogout() {
		$this->getPresenter()->handleLogout();
	}
}
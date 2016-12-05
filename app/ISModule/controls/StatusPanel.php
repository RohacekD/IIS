<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 23.11.2016
 * Time: 16:36
 */

namespace App\ISModule\Controls;

use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Control,
	Nette;
use Tracy\Debugger;

/**
 * Class StatusPanel
 * @package App\ISModule\Controls
 */
class StatusPanel extends Control {
	/** @var Nette\Security\Identity */
	private $user;

	public function __construct( Nette\Security\IIdentity $user ) {
		parent::__construct();
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

	/**
	 *
	 */
	public function handleLogout() {
		$this->getPresenter()->handleLogout();
	}
}
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

class StatusPanel extends Control {
	/** @var Nette\Database\Context */
	protected $database;

	public function __construct( $id ) {
		parent::__construct();
	}

	public function injectDatabase( Nette\Database\Context $database ) {
		$this->database = $database;
	}

	public function render() {
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/StatusPanel.latte" );
		$this->template->render();
	}
}
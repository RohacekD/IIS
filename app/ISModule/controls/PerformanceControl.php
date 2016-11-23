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

class PerformanceControl extends Control {
	/** @var Nette\Database\Context */
	protected $database;

	public function __construct( $id ) {
		parent::__construct();
	}

	public function injectDatabase( Nette\Database\Context $database ) {
		$this->database = $database;
	}

	public function render() {
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/Performance.latte" );
		$this->template->render();
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 23.11.2016
 * Time: 16:36
 */

namespace App\ISModule\Controls;

use Kdyby\Doctrine\EntityManager;
use App\ISModule\Model;
use Nette\Application\UI\Control,
	Nette;

/**
 * Class PerformanceControl
 * @package App\ISModule\Controls
 */
class PerformanceControl extends Control {
	/**
	 * @var
	 */
	public $id;
	/**
	 * @var Nette\Security\Identity
	 */
	public $user;
	/** @var EntityManager */
	protected $entityManager;

	/**
	 * PerformanceControl constructor.
	 *
	 * @param Nette\Security\IIdentity $user
	 * @param EntityManager $entityManager
	 */
	public function __construct( Nette\Security\IIdentity $user, EntityManager $entityManager ) {
		parent::__construct();
		$this->entityManager = $entityManager;
		$this->user          = $user;
	}

	/**
	 * Prepare data for rendering
	 */
	public function render( $id ) {
		$this->id = $id;
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/Performance.latte" );
		$this->template->performance = $this->entityManager->getRepository(Model\Performance::class)->findOneById($id);
		$this->template->play        = $this->template->performance->getProduction()->getPlay();
		$this->template->roles       = $this->template->performance->getProduction()->getRoles();
		$this->template->render();
	}
}
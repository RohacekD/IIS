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
class RehearsalControl extends Control {
	/**
	 * @var Nette\Security\Identity
	 */
	public $user;
	/** @var EntityManager */
	protected $entityManager;

	/**
	 * RehearsalControl constructor.
	 *
	 * @param Nette\Security\IIdentity $user
	 * @param EntityManager $em
	 */
	public function __construct( Nette\Security\IIdentity $user, EntityManager $em ) {
		parent::__construct();
		$this->entityManager = $em;
		$this->user     = $user;
	}

	/**
	 * Prepare data for rendering
	 */
	public function render( $id ) {
		$this->template->setFile( __DIR__ . "/../presenter/templates/components/Rehearsal.latte" );
		$this->template->rehearsal = $this->entityManager->getRepository(Model\Rehearsal::class)->findOneById($id);
		$this->template->render();
	}
}
<?php

namespace App\ISModule\Presenters;

use Nette;
use App\ISModule\Model;
use App\ISModule\Controls;
use Tracy\Debugger;


class HomepagePresenter extends SecuredPresenter {

	public function createComponentPerformance() {
		return new Controls\PerformanceControl( $this->getUser()->getIdentity(), $this->entityManager );
	}

	public function createComponentRehearsal() {
		return new Controls\RehearsalControl( $this->getUser()->getIdentity(), $this->entityManager );
	}


	public function renderDefault() {
		/** @var \Kdyby\Doctrine\EntityManager $em */
		$em                                   = $this->entityManager;
		$this->template->upcomingPerformances =
			$em->createQuery( 'SELECT r.id FROM App\ISModule\Model\Performance r JOIN r.production p JOIN p.roles s JOIN s.actors users WHERE users.id = :a ORDER BY r.date' )
			   ->setParameter( "a", $this->getUser()->getIdentity()->getId() )
			   ->setMaxResults( 4 )
			   ->getResult();
		$this->template->upcomingRehearsals =
			$em->createQuery( 'SELECT r.id FROM App\ISModule\Model\Rehearsal r JOIN r.production p JOIN p.roles s JOIN s.actors users WHERE users.id = :a ORDER BY r.date' )
			   ->setParameter( "a", $this->getUser()->getIdentity()->getId() )
			   ->setMaxResults( 4 )
			   ->getResult();
	}
}

<?php

namespace App\ISModule\Presenters;

use Nette;
use App\Model;
use App\ISModule\Controls;


class HomepagePresenter extends SecuredPresenter
{

	public function createComponentPerformance() {
		return new Controls\PerformanceControl( $this->getUser()->getIdentity(), $this->database );
	}

	public function createComponentRehearsal() {
		return new Controls\RehearsalControl( $this->getUser()->getIdentity(), $this->database );
	}


	public function renderDefault()
	{

	}

}

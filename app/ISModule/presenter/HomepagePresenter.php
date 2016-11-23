<?php

namespace App\ISModule\Presenters;

use Nette;
use App\Model;
use App\ISModule\Controls;


class HomepagePresenter extends SecuredPresenter
{

	public function createComponentPerformance( $id ) {
		return new Controls\PerformanceControl( $id );
	}

	public function renderDefault()
	{

	}

}

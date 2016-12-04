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
		$this->template->upcomingPerformances =
			$this->database->query( "
				SELECT `Predstaveni`.`ID` 
				FROM `Predstaveni` 
				LEFT JOIN `Inscenace` ON `Predstaveni`.`ID_Inscenace` = `Inscenace`.ID 
				LEFT JOIN `Predstaveni_Herec` ON `Predstaveni`.`ID` = `Predstaveni_Herec`.`ID_Predstaveni`
				WHERE (`Predstaveni_Herec`.`login_Herec` = 'Irimitenkan') 
				ORDER BY `Predstaveni`.`Datum` 
				LIMIT 4" )->fetchAll();
	}
}

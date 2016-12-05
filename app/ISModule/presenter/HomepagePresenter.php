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
				WHERE (`Predstaveni_Herec`.`login_Herec` = '" . $this->getUser()->getId() . "') 
				ORDER BY `Predstaveni`.`Datum` 
				LIMIT 4" )->fetchAll();
		$this->template->upcomingRehearsals   =
			$this->database->query( "
				SELECT `Zkouska`.ID 
				FROM `Zkouska` 
				LEFT JOIN `Inscenace` ON `Zkouska`.`Inscenace_ID` = `Inscenace`.`ID`
				LEFT JOIN `Inscenace_Herec` ON `Inscenace`.`ID` = `Inscenace_Herec`.`ID_Inscenace`
				WHERE (`Inscenace_Herec`.`login_Herec` = '" . $this->getUser()->getId() . "') 
				ORDER BY `Zkouska`.`Datum` 
				LIMIT 4" )->fetchAll();
	}
}

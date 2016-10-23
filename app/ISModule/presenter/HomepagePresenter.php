<?php

namespace App\ISModule\Presenters;

use Nette;
use App\Model;


class HomepagePresenter extends SecuredPresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}

<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:54
 */

namespace App\ISModule\Presenters;

use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;
use Nette;

class PropertiesPresenter extends SecuredPresenter
{

	public function createComponentSimpleGrid($name)
	{
		$grid = new DataGrid($this, $name);

		$source = $this->database->table("Rekvizita");
		$grid->setPrimaryKey("ID");
		$grid->setTranslator($this->translator);
		$grid->setDataSource($source);
		$grid->addColumnText('nazev', 'tables.properties.name');
		$grid->addColumnText('stav', 'tables.properties.state');
		$grid->addAction("delete", "", "delete!")
			->setIcon('trash')
			->setTitle('Delete')
			->setClass('btn btn-xs btn-danger ajax')
			->setConfirm('Do you really want to delete example %s?', 'nazev');

		$grid->setItemsDetail();
	}


	public function renderDefault()
	{

	}

	public function handleDelete($id)
	{
		Debugger::dump($id);
	}
}
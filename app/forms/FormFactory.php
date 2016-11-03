<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;




class FormFactory
{
	use Nette\SmartObject;


	/** @var \Kdyby\Translation\Translator */
	public $translator;

	public function __construct(\Kdyby\Translation\Translator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form();
		$form->setTranslator($this->translator);
		return $form;
	}

}

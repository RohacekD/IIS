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

		$renderer                                        = $form->getRenderer();
		$renderer->wrappers['controls']['container']     = null;
		$renderer->wrappers['pair']['container']         = 'div class=control-group';
		$renderer->wrappers['pair']['.error']            = 'error';
		$renderer->wrappers['control']['container']      = 'div class=controls';
		$renderer->wrappers['label']['container']        = 'div class=control-label';
		$renderer->wrappers['control']['description']    = 'span class=help-inline';
		$renderer->wrappers['control']['errorcontainer'] = 'span class=help-inline';
		$form->setTranslator($this->translator);
		return $form;
	}

}

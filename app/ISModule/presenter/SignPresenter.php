<?php

namespace App\ISModule\Presenters;

use Nette;
use App\ISModule\Forms;


class SignPresenter extends BasePresenter
{
	/** @var Forms\SignInFormFactory @inject */
	public $signInFactory;

	/** @persistent */
	public $backlink = '';

	public function beforeRender()
	{
		parent::beforeRender();

	}


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		return $this->signInFactory->create(function () {
			$this->restoreRequest($this->backlink);
			$this->redirect('Homepage:');
		});
	}


	public function actionOut()
	{
		$this->getUser()->logout();
	}

}

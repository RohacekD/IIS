<?php
/**
 * Created by PhpStorm.
 * User: irimitenkan
 * Date: 16.6.14
 * Time: 12:15
 */

namespace App\ISModule\Presenters;

use Nette;


class SecuredPresenter extends BasePresenter
{
	/** @var Nette\Http\Request @inject */
	public $http_request;
	/** @var Nette\Database\Context @inject */
	public $database;

	protected function startup()
	{
		parent::startup();

		if(!$this->getUser()->isLoggedIn()){

			$this->redirect('Sign:in', array('backlink' => $this->storeRequest()));

		}
	}

	public function handleLogout(){
		$this->getUser()->logout();
		$this->redirect("Sign:In");
	}

	protected function beforeRender()
	{
		parent::beforeRender();

		// $this->template->menuItems = $this->createMenu();

		/*else if(!$this->getUser()->isAllowed("warehouse", "enter") && $this->getUser()->isLoggedIn()){
			throw new Nette\Application\ForbiddenRequestException;
		}*/
		$this->template->user = $this->getUser();
	}

}
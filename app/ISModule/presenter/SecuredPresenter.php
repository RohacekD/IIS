<?php
/**
 * Created by PhpStorm.
 * User: irimitenkan
 * Date: 16.6.14
 * Time: 12:15
 */

namespace App\ISModule\Presenters;

use Nette;
use Tracy\Debugger;
use App\ISModule\Controls;


class SecuredPresenter extends BasePresenter
{
	/** @var Nette\Http\Request @inject */
	public $http_request;
	/** @var Nette\Database\Context @inject */
	public $database;

	public function handleLogout() {
		$this->getUser()->logout();
		$this->redirect( "Sign:In" );
	}

	public function createComponentStatusPanel() {
		return new Controls\StatusPanel( $this->getUser()->getIdentity(), $this->database );
	}

	protected function createComponentMenu() {
		return new Controls\MenuControl( $this->getUser()->getIdentity() );
	}

	protected function startup()
	{
		parent::startup();
		if(!$this->getUser()->isLoggedIn()){

			$this->redirect('Sign:in', array('backlink' => $this->storeRequest()));

		}
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
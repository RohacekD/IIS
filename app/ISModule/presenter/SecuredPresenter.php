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
use Kdyby\Doctrine\EntityManager;


class SecuredPresenter extends BasePresenter
{
	/** @var Nette\Http\Request @inject */
	public $http_request;

	/**
	 * @inject
	 * @var \Kdyby\Doctrine\EntityManager
	 */
	public $entityManager;

	public function handleLogout() {
		$this->getUser()->logout();
		$this->redirect( "Sign:In" );
	}

	public function createComponentStatusPanel() {
		return new Controls\StatusPanel( $this->getUser()->getIdentity() );
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

	/**
	 * @return EntityManager
	 */
	public function getEm(){
		return $this->entityManager;
	}

	protected function beforeRender()
	{
		parent::beforeRender();

		$this->template->user = $this->getUser();
	}

}
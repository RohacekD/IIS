<?php
/**
 * Created by PhpStorm.
 * User: irimitenkan
 * Date: 16.6.14
 * Time: 12:15
 */

namespace App\ISModule\Presenters;

use App\Presenters\BasePresenter;
use Nette,
    App\Model;


class SecuredPresenter extends BasePresenter {
    /** @var Nette\Http\Request */
    protected $http_request;
    /** @var Nette\Database\Context */
    protected $database;

    public  function injectHttpRequest(Nette\Http\Request $http_request)
    {
        $this->http_request = $http_request;
    }

    public function injectDatabase(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    protected function beforeRender()
    {
        parent::beforeRender();

        $this->template->menuItems = $this->createMenu();

        if(!$this->getUser()->isAllowed("warehouse", "enter") && !$this->getUser()->isLoggedIn()){
            if($this->name!="Admin:Sign" || $this->action!="in")//prevent redirect loop
                $this->redirect("Sign:in");
        }
        else if(!$this->getUser()->isAllowed("warehouse", "enter") && $this->getUser()->isLoggedIn()){
            throw new Nette\Application\ForbiddenRequestException;
        }
        $this->template->user = $this->getUser();
    }

}
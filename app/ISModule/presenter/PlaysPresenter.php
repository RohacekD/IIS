<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:01
 */

namespace App\ISModule\Presenters;

use App\ISModule\Forms;


class PlaysPresenter extends SecuredPresenter
{
    /** @var Forms\PlayFormFactory @inject */
    public $playFormFactory;

    protected function createComponentAddPlay()
    {

        return $this->playFormFactory->create(function () {
        });
    }
}
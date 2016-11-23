<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 23.11.2016
 * Time: 14:33
 */

namespace App\ISModule\Controls;

use Nette\Application\UI\Control,
    Nette;
use Tracy\Debugger;

class MenuControl extends Control
{
    /** @var Nette\Database\Context */
    protected $database;
    /** @var  Nette\Security\Identity */
    private $user;

    public function __construct(Nette\Security\Identity $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function injectDatabase(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . "/../presenter/templates/components/Menu.latte");
        $this->template->menuItems = $this->createMenu();
        $this->template->render();
    }

    /**
     * @return array
     */
    private function createMenu()
    {
        $return = array();
        if ($this->user->getRoles()[0] == "actor") {
            $return = array(
                'Performances:my' => ['name' => 'Představení mé', 'class' => 'performance'],
                'Productions:my' => ['name' => 'Inscenace mé', 'class' => 'production'],
                'Role:My' => ['name' => 'Role mé', 'class' => 'role'],
                'Rehearsals:my' => ['name' => 'Zkoušky mé', 'class' => 'rehearsals']
            );
        } elseif ($this->user->getRoles()[0] == "director") {
            $return = array(
                'Plays:list' => ['name' => 'Hry', 'class' => 'plays'],
                'Productions:list' => ['name' => 'Inscenace', 'productions' => ''],
                'Rehearsals:list' => ['name' => 'Zkoušky', 'rehearsals' => '']
            );
        } elseif ($this->user->getRoles()[0] == "organizer") {
            $return = array(
                'Performanes:list' => ['name' => 'Představení', 'class' => 'performance'],
                'Productions:list' => ['name' => 'Inscenace', 'class' => 'productions'],
                'Plays:list' => ['name' => 'Hry', 'class' => 'plays'],
                'Rehearsals:list' => ['name' => 'Zkoušky', 'rehearsals' => '']
            );
        }

        return $return;
    }
}
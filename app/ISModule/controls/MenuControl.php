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

/**
 * Class MenuControl
 * @package App\ISModule\Controls
 */
class MenuControl extends Control
{
    /** @var Nette\Database\Context */
    protected $database;
    /** @var  Nette\Security\Identity */
    private $user;

	/**
	 * MenuControl constructor.
	 *
	 * @param Nette\Security\IIdentity $user
	 */
	public function __construct( Nette\Security\IIdentity $user )
    {
        parent::__construct();
        $this->user = $user;
    }

	/**
	 * @param Nette\Database\Context $database
	 */
	public function injectDatabase( Nette\Database\Context $database )
    {
        $this->database = $database;
    }

	/**
	 *
	 */
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
	            'Plays:list'       => ['name' => 'Hry', 'class' => 'plays'],
	            'Productions:list' => [ 'name' => 'Inscenace', 'class' => 'production' ],
	            'Rehearsals:list'  => [ 'name' => 'Zkoušky', 'class' => 'rehearsals' ]
            );
        } elseif ($this->user->getRoles()[0] == "organizer") {
            $return = array(
	            'Performances:list' => [ 'name' => 'Představení', 'class' => 'performance' ],
	            'Productions:list'  => [ 'name' => 'Inscenace', 'class' => 'production' ],
	            'Plays:list'        => ['name' => 'Hry', 'class' => 'plays'],
	            'Rehearsals:list'   => [ 'name' => 'Zkoušky', 'class' => 'rehearsals' ],
	            'Users:list'        => [ 'name' => 'Uživatelé', 'class' => 'user' ],
            );
        }

        return $return;
    }
}
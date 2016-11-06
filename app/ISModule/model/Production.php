<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:05
 */

namespace App\ISModule\Model;

use Grido\Exception;
use Nette;

/**
 * Class Production
 * @package App\ISModule\Model
 * @brief Means "inscenace"
 */
class Production extends MyModel
{
	const SCENES = array("Malá", "Velká");
	/** @var int */
	private $id = null;
	/** @var  string */
	private $name;
	//todo: model
	/** @var  string */
	private $scene;
	/** @var User */
	private $director = null;
	/** @var  int */
	private $director_id;
	/** @var  Play */
	private $play;
	/** @var  int */
	private $play_id;


	/** @var Performance array */
	private $performances = null;

	/** @var Role array */
	private $roles = null;

	/**
	 * Production constructor.
	 * @param int $id
	 */
	public function __construct($id)
	{
		parent::__construct("inscenace");
		if($id){
			$this->getById($id);
		}
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return Performance
	 */
	public function getPerformances()
	{
		if (!$this->performances){}
			//TODO: lazy allocation
		return $this->performances;
	}

	/**
	 * @param Performance $performances
	 */
	public function setPerformances($performances)
	{
		$this->performances = $performances;
	}


	/**
	 * @return Role
	 */
	public function getRoles()
	{
		if (!$this->roles){}
		//TODO: lazy allocation
		return $this->roles;
	}

	/**
	 * @param Role $roles
	 */
	public function setRoles($roles)
	{
		$this->roles = $roles;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getScene()
	{
		return $this->scene;
	}

	/**
	 * @param $scene
	 * @throws Exception if scene name is wrong
	 */
	public function setScene($scene)
	{
		if(!in_array($scene, self::SCENES))
			throw new Exception("Špatné jméno scény");
		$this->scene = $scene;
	}

	/**
	 * @return User
	 */
	public function getDirector()
	{
		if (!$this->director)
			$this->director = new User($this->director_id);
		return $this->director;
	}

	/**
	 * @param User $director
	 */
	public function setDirector($director)
	{
		$this->director = $director;
	}

	/**
	 * @param $id
	 */
	public function getById($id)
	{
		$row = $this->getModelsRow($id);

	}

	public function saveModel()
	{
		$data = array();
		if($this->id){
			$data["id"] = $this->id;
		}
		if(!$this->name){
			throw new Exception("Production have to have a name");
		}
		$data["nazev"] = $this->name;
		$data["scena"] = $this->scene;
		$data["login_Reziser"] = $this->director_id;
		$data["ID_Divadelni_hra"] = $this->play_id;
	}


}
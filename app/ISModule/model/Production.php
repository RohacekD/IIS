<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:05
 */

namespace App\ISModule\Model;

use Nette;

/**
 * Class Production
 * @package App\ISModule\Model
 * @brief Means "inscenace"
 */
class Production
{
	use Nette\SmartObject;

	const TABLE_NAME = 'inscenace';

	/** @var int */
	private $id;

	/** @var  string */
	private $name;

	//todo: model
	private $scene;

	/** @var User */
	private $director = null;


	/** @var Performance array */
	private $performances = null;

	/** @var Role array */
	private $roles = null;

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
		if (!$this->scene){}
		//TODO: lazy allocation
		return $this->scene;
	}

	/**
	 * @param mixed $scene
	 */
	public function setScene($scene)
	{
		$this->scene = $scene;
	}

	/**
	 * @return User
	 */
	public function getDirector()
	{
		return $this->director;
	}

	/**
	 * @param User $director
	 */
	public function setDirector($director)
	{
		$this->director = $director;
	}


}
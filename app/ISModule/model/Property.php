<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:04
 */

namespace App\ISModule\Model;

use Grido\Exception;
use Nette;

class Property extends MyModel
{
	const STATES = array('nová', 'použitá', 'poškozená','velmi poškozená');
	/** @var  int */
	private $id;
	/** @var  string */
	private $name;
	/** @var  string one of self::STATES */
	private $state;

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
	 * @return string
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @param $state
	 * @throws Exception
	 */
	public function setState($state)
	{
		if(!in_array($state, self::STATES))
			throw new Exception("Wrong state of the property.");
		$this->state = $state;
	}

	/**
	 * Property constructor.
	 * @param $id
	 */
	public function __construct($id)
	{
		parent::__construct("Rekvizita");
		if($id){
			$this->getById($id);
		}
	}

	public function getById($id)
	{
		$row = $this->getModelsRow($id);
		$this->id = $row["id"];
		$this->name = $row["nazev"];
		$this->setState($row["stav"]);
	}

	public function saveModel()
	{
		$data = array();
		if($this->id){
			$data["id"] = $this->id;
		}
		if(!$this->name){
			throw new Exception("Proeprty have to have a name");
		}
		$data["nazev"] = $this->name;
		$data["stav"] = $this->state;
		$this->saveToDB($data);
	}

}
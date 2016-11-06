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

class Role extends MyModel
{
	const DIFFICULTIES = array('nízká', 'střední', 'vysoká');
	private $id;
	private $name;
	private $difficulty;
	private $time_difficulty;
	private $description;
	private $production = null;
	private $production_id;

	/**
	 * Role constructor.
	 * @param $id
	 */
	public function __construct($id)
	{
		parent::__construct("Role");
		if($id){
			$this->getById($id);
		}
	}


	public function getById($id)
	{
		$row = $this->getModelsRow($id);
		$this->id = $row["id"];
		$this->name = $row["nazev"];
		$this->setDifficulty($row["obtiznost"]);
		$this->time_difficulty = $row["casova_narocnost"];
		$this->description = $row["popis"];
		$this->production_id = $row["ID_inscenace"];
		$this->production = null;

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
		$data["obtiznost"] = $this->difficulty;
		$data["casova_narocnost"] = $this->time_difficulty;
		$data["popis"] = $this->description;
		$data["ID_inscenace"] = $this->production_id;
		$this->saveToDB($data);
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getDifficulty()
	{
		return $this->difficulty;
	}

	/**
	 * @param $difficulty
	 * @throws Exception
	 */
	public function setDifficulty($difficulty)
	{
		if(!in_array($difficulty, self::DIFFICULTIES))
			throw new Exception("Wrong difficulty");
		$this->difficulty = $difficulty;
	}

	/**
	 * @return mixed
	 */
	public function getTimeDifficulty()
	{
		return $this->time_difficulty;
	}

	/**
	 * @param mixed $time_difficulty
	 */
	public function setTimeDifficulty($time_difficulty)
	{
		$this->time_difficulty = $time_difficulty;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getProductionId()
	{
		return $this->production_id;
	}

	/**
	 * @param mixed $production_id
	 */
	public function setProductionId($production_id)
	{
		$this->production_id = $production_id;
	}

}
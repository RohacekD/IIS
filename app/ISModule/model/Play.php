<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:03
 */

namespace App\ISModule\Model;

use Nette;

/**
 * Class Play
 * @package App\ISModule\Model
 */
class Play extends MyModel
{
	/** @var  int */
	private $id;
	/** @var  string */
	private $author;
	/** @var  string */
	private $name;
	/** @var  string */
	private $description;
	/** @var  Nette\Utils\DateTime */
	private $time_needed;

	/**
	 * Play constructor.
	 * @param int $id
	 */
	public function __construct($id)
	{
		parent::__construct("Divadelni_hra");
		if($id){
			$this->getById($id);
		}
	}

	public function getById($id)
	{
		$row = $this->getModelsRow($id);
		$this->id = $row["id"];
		$this->author = $row["autor"];
		$this->name = $row["jmeno"];
		$this->description = $row["popis"];
		$this->time_needed = new Nette\Utils\DateTime($row["casova_narocnost"]);
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
		$data["autor"] = $this->author;
		$data["jmeno"] = $this->name;
		$data["popis"] = $this->description;
		$data["casova_narocnost"] = $this->time_needed;
		$this->saveToDB($data);
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
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param string $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
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
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return Nette\Utils\DateTime
	 */
	public function getTimeNeeded()
	{
		return $this->time_needed;
	}

	/**
	 * @param Nette\Utils\DateTime $time_needed
	 */
	public function setTimeNeeded($time_needed)
	{
		$this->time_needed = $time_needed;
	}


}
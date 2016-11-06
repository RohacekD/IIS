<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 16:00
 */

namespace App\ISModule\Model;

use Grido\Exception;
use Nette;


/**
 * Class MyModel
 * @package App\ISModule\Model
 */
abstract class MyModel
{
	use Nette\SmartObject;

	/** @var Nette\Database\Context @inject */
	protected $database;
	/** @var  string */
	protected $table_name;

	/**
	 * MyModel constructor.
	 * @param $table_name
	 */
	public function __construct($table_name)
	{
		$this->table_name = $table_name;
	}


	/**
	 * @param $id
	 */
	abstract public function getById($id);

	/**
	 * @param $id
	 * @return Nette\Database\Table\Selection
	 * @throws Exception
	 */
	protected function getModelsRow($id){
		$row = $this->database->table($this->table_name)->where(array("id" => $id));
		if(!$row)
			throw new Exception("ID not found");
		return $row;
	}

	/**
	 * @return mixed
	 */
	abstract public function saveModel();

	/**
	 * @param array $data
	 */
	protected function saveToDB($data = array()){
		if(!in_array("id", $data)){
			$this->database->table($this->table_name)->insert($data);
		}
		else{
			$id = $data["id"];
			unset($data["id"]);
			$this->database->table($this->table_name)->where($id)->update($data);
		}
	}
}
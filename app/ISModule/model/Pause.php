<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:59
 */

namespace App\ISModule\Model;

use Nette;


class Pause extends MyModel
{
	private $id;
	/**
	 * Pause constructor.
	 * @param int $id
	 */
	public function __construct($id = null)
	{
		parent::__construct("Prestavka");
		if($id){
			$this->getById($id);
		}
	}

	public function getById($id)
	{
		// TODO: Implement getById() method.
	}
	public function saveModel()
	{
		// TODO: Implement saveModel() method.
	}

}
<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:04
 */

namespace App\ISModule\Model;

use Nette;

/**
 * Class Contact
 * @package App\ISModule\Model
 * TODO: Facade?
 */
class Contact extends MyModel
{
	private $id;

	/**
	 * Contact constructor.
	 * @param $id
	 */
	public function __construct($id)
	{
		parent::__construct("Kontakt");
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
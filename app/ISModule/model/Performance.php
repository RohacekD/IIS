<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:03
 */

namespace App\ISModule\Model;

use Nette;

class Performance extends MyModel
{


	/**
	 * Performance constructor.
	 * @param int $id
	 */
	public function __construct($id = null)
	{
		parent::__construct("predstaveni");
		if($id){
			$this->getById($id);
		}
	}

	public function getById($id)
	{
		$row = $this->getModelsRow($id);

	}


}
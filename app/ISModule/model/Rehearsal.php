<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.12.2016
 * Time: 12:30
 */

namespace App\ISModule\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Rehearsal
 * @package app\ISModule\model
 * @ORM\Entity
 */
class Rehearsal {
	use \Kdyby\Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date;

	/**
	 * @ORM\ManyToOne(targetEntity="Production", inversedBy="performances")
	 */
	protected $production;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param mixed $date
	 */
	public function setDate( $date ) {
		$this->date = $date;
	}

	/**
	 * @return mixed
	 */
	public function getProduction() {
		return $this->production;
	}

	/**
	 * @param mixed $production
	 */
	public function setProduction( $production ) {
		$this->production = $production;
	}
}
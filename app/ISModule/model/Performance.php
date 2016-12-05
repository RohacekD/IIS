<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:03
 */

namespace App\ISModule\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * Class Performance
 * @package App\ISModule\Model
 * @ORM\Entity
 */
class Performance {
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
	 * Many Roles is played by many users.
	 * @ORM\ManyToMany(targetEntity="User")
	 * @ORM\JoinTable(name="performance_actors",
	 *      joinColumns={@ORM\JoinColumn(name="Performance_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="User_id", referencedColumnName="id", unique=true)}
	 *      )
	 */
	private $actors;

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

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getActors() {
		return $this->actors;
	}

	/**
	 * @param mixed $actors
	 */
	public function setActors( $actors ) {
		$this->actors = $actors;
	}


}
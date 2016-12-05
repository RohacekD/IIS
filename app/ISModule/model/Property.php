<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:04
 */

namespace App\ISModule\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * Class Property
 * @package App\ISModule\Model
 * @ORM\Entity
 */
class Property
{
	use \Kdyby\Doctrine\Entities\Attributes\Identifier;
	const STATES = array('nová', 'použitá', 'poškozená','velmi poškozená');

	/**
	 * @ORM\Column(type="string", length=128)
	 */
	private $name;
	/**
	 * @ORM\Column(type="string", length=25, columnDefinition="ENUM('nová', 'použitá', 'poškozená','velmi poškozená')",nullable=false)
	 */
	private $state;

	/**
	 * @ORM\ManyToOne(targetEntity="Role", inversedBy="properties")
	 */
	protected $role;

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param mixed $state
	 */
	public function setState( $state ) {
		$this->state = $state;
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
	public function getRole() {
		return $this->role;
	}

	/**
	 * @param mixed $role
	 */
	public function setRole( $role ) {
		$this->role = $role;
	}


}
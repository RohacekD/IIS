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
 * Class Play
 * @package App\ISModule\Model
 * @ORM\Entity
 */
class Play
{
	use \Kdyby\Doctrine\Entities\Attributes\Identifier;
	/**
	 * @ORM\Column(type="string", length=128)
	 */
	private $author;
	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private $name;
	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $description;
	/**
	 * @ORM\Column(type="time")
	 */
	private $time_needed;
	/**
	 * @ORM\Column(type="string", length=128)
	 */
	private $photo;

	/**
	 * @return mixed
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @param mixed $author
	 */
	public function setAuthor( $author ) {
		$this->author = $author;
	}

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
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getTimeNeeded() {
		return $this->time_needed;
	}

	/**
	 * @param mixed $time_needed
	 */
	public function setTimeNeeded( $time_needed ) {
		$this->time_needed = $time_needed;
	}

	/**
	 * @return mixed
	 */
	public function getPhoto() {
		return $this->photo;
	}

	/**
	 * @param mixed $photo
	 */
	public function setPhoto( $photo ) {
		$this->photo = $photo;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}
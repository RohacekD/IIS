<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:05
 */

namespace App\ISModule\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * Class Production
 * @package App\ISModule\Model
 * @ORM\Entity
 * Means "inscenace"
 */
class Production
{

	use \Kdyby\Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="string", length=25)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=25, columnDefinition="ENUM('small', 'big')",nullable=false)
	 */
	private $scene;
	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 */
	private $director;

	/**
	 * @ORM\ManyToOne(targetEntity="Play")
	 */
	private $play;

	/**
	 * @ORM\OneToMany(targetEntity="Role", mappedBy="production")
	 */
	private $roles = null;

	/**
	 * @ORM\OneToMany(targetEntity="Role", mappedBy="pause")
	 */
	private $pauses = null;

	/**
	 * @ORM\OneToMany(targetEntity="Performance", mappedBy="performance")
	 */
	private $performances;

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
	public function getScene() {
		return $this->scene;
	}

	/**
	 * @param mixed $scene
	 */
	public function setScene( $scene ) {
		$this->scene = $scene;
	}

	/**
	 * @return mixed
	 */
	public function getDirector() {
		return $this->director;
	}

	/**
	 * @param mixed $director
	 */
	public function setDirector( $director ) {
		$this->director = $director;
	}

	/**
	 * @return mixed
	 */
	public function getPlay() {
		return $this->play;
	}

	/**
	 * @param mixed $play
	 */
	public function setPlay( $play ) {
		$this->play = $play;
	}

	/**
	 * @return mixed
	 */
	public function getRoles() {
		return $this->roles;
	}

	/**
	 * @param mixed $roles
	 */
	public function setRoles( $roles ) {
		$this->roles = $roles;
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
	public function getPauses() {
		return $this->pauses;
	}

	/**
	 * @param mixed $pauses
	 */
	public function setPauses( $pauses ) {
		$this->pauses = $pauses;
	}

	/**
	 * @return mixed
	 */
	public function getPerformances() {
		return $this->performances;
	}

	/**
	 * @param mixed $performances
	 */
	public function setPerformances( $performances ) {
		$this->performances = $performances;
	}


}
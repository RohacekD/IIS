<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:05
 */

namespace App\ISModule\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * Class Role
 * @package App\ISModule\Model
 * @ORM\Entity
 */
class Role {
	use \Kdyby\Doctrine\Entities\Attributes\Identifier;
	const DIFFICULTIES = array( 'nízká', 'střední', 'vysoká' );

	private $name;
	/**
	 * @ORM\Column(type="string", length=25, columnDefinition="ENUM('nízká', 'střední', 'vysoká')")
	 */
	private $difficulty;
	/**
	 * @ORM\Column(type="string", length=25, columnDefinition="ENUM('nízká', 'střední', 'vysoká')")
	 */
	private $time_difficulty;
	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $description;

	/**
	 * @ORM\ManyToOne(targetEntity="Production", inversedBy="roles")
	 */
	private $production = null;

	/**
	 * @ORM\OneToMany(targetEntity="Property", mappedBy="property")
	 */
	private $properties;

	/**
	 * Many Roles is played by many users.
	 * @ORM\ManyToMany(targetEntity="User")
	 * @ORM\JoinTable(name="Role_actors",
	 *      joinColumns={@ORM\JoinColumn(name="Role_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="User_id", referencedColumnName="id", unique=true)}
	 *      )
	 */
	private $actors;

	/**
	 * Role constructor.
	 */
	public function __construct() {
			$this->actors = new ArrayCollection();
	}


	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
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
	public function getDifficulty() {
		return $this->difficulty;
	}

	/**
	 * @param $difficulty
	 *
	 * @throws Exception
	 */
	public function setDifficulty( $difficulty ) {
		if ( ! in_array( $difficulty, self::DIFFICULTIES ) ) {
			throw new Exception( "Wrong difficulty" );
		}
		$this->difficulty = $difficulty;
	}

	/**
	 * @return mixed
	 */
	public function getTimeDifficulty() {
		return $this->time_difficulty;
	}

	/**
	 * @param mixed $time_difficulty
	 */
	public function setTimeDifficulty( $time_difficulty ) {
		$this->time_difficulty = $time_difficulty;
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
	public function getProductionId() {
		return $this->production_id;
	}

	/**
	 * @param mixed $production_id
	 */
	public function setProductionId( $production_id ) {
		$this->production_id = $production_id;
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
	 * @return mixed
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * @param mixed $properties
	 */
	public function setProperties( $properties ) {
		$this->properties = $properties;
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
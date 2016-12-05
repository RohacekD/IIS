<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 06.11.2016
 * Time: 0:04
 */

namespace App\ISModule\Model;

use Doctrine\ORM\Mapping as ORM;

use Nette\Security\IIdentity;

/**
 * @ORM\Entity
 */
class User implements IIdentity
{
	use \Kdyby\Doctrine\Entities\Attributes\Identifier;

	/** @ORM\Column(type="string", columnDefinition="ENUM('director', 'actor', 'organizer')") */
	protected  $role;

	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 */
	protected $username;
	/**
	 * @ORM\Column(type="string", length=25, nullable=true)
	 */
	protected $sirName;
	/**
	 * @ORM\Column(type="string", length=25, nullable=true)
	 */
	protected $lastName;
	/**
	 * @ORM\Column(type="string", length=25, columnDefinition="ENUM('male', 'female')", nullable=true)
	 */
	protected $sex;
	/**
	 * @ORM\Column(type="string", length=64)
	 */
	protected $password;

	function getRoles() {
		return [$this->role];
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

	/**
	 * @return mixed
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername( $username ) {
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getSirName() {
		return $this->sirName;
	}

	/**
	 * @param mixed $sirName
	 */
	public function setSirName( $sirName ) {
		$this->sirName = $sirName;
	}

	/**
	 * @return mixed
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param mixed $lastName
	 */
	public function setLastName( $lastName ) {
		$this->lastName = $lastName;
	}

	/**
	 * @return mixed
	 */
	public function getSex() {
		return $this->sex;
	}

	/**
	 * @param mixed $sex
	 */
	public function setSex( $sex ) {
		$this->sex = $sex;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword( $password ) {
		$this->password = $password;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}
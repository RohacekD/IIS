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
 * Class Contact
 * @package App\ISModule\Model
 * @ORM\Entity
 */
class Contact
{
	/** @ORM\Id @ORM\ OneToOne(targetEntity="User") */
	private $user;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $city;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $street;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $houseNumber;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $phone;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $email;

	/**
	 * Contact constructor.
	 *
	 * @param $user
	 */
	public function __construct( $user ) {
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user ) {
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @param mixed $city
	 */
	public function setCity( $city ) {
		$this->city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * @param mixed $street
	 */
	public function setStreet( $street ) {
		$this->street = $street;
	}

	/**
	 * @return mixed
	 */
	public function getHouseNumber() {
		return $this->houseNumber;
	}

	/**
	 * @param mixed $houseNumber
	 */
	public function setHouseNumber( $houseNumber ) {
		$this->houseNumber = $houseNumber;
	}

	/**
	 * @return mixed
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 */
	public function setPhone( $phone ) {
		$this->phone = $phone;
	}

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail( $email ) {
		$this->email = $email;
	}

}
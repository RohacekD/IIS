<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.11.2016
 * Time: 23:59
 */

namespace App\ISModule\Model;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * Class Pause
 * @package App\ISModule\Model
 * @ORM\Entity
 */
class Pause
{
	use \Kdyby\Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="time")
	 */
	private $time;
	/**
	 * @ORM\Column(type="time")
	 */
	private $duration;

	/**
	 * @ORM\ManyToOne(targetEntity="Production", inversedBy="pauses")
	 */
	private $production;
}
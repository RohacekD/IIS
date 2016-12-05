<?php

namespace App\ISModule\Model;

use Nette;
use Nette\Security\Passwords;
use App\ISModule\Model;
use Kdyby\Doctrine\EntityManager;
use Doctrine;
use Tracy\Debugger;


/**
 * Class UserManager
 * @package App\ISModule\Model
 */
class UserManager implements Nette\Security\IAuthenticator {
	use Nette\SmartObject;

	/**
	 * @var \Kdyby\Doctrine\EntityManager
	 */
	public $entityManager;

	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	/**
	 * @param array $credentials
	 *
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 *
	 * @return Nette\Security\IIdentity
	 */
	public function authenticate( array $credentials ) {

		/*$this->add( "actor", "actor", "actor" );
		$this->add( "director", "director", "director" );
		$this->add( "organizer", "organizer", "organizer" );*/
		list($login, $password) = $credentials;

		/** @var Model\User $user */
		$user = $this->entityManager->getRepository(Model\User::class)->findOneBy([
			'username' => $login
		]);

		if (!$user)
		{
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		}
		elseif (!Passwords::verify($password, $user->getPassword()))
		{
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}
		elseif (Passwords::needsRehash($user->getPassword()))
		{
			$user->setPassword(Passwords::hash($password));
			$this->entityManager->persist($user);
			$this->entityManager->flush();
		}

		return $user;
	}

	/**
	 * @param $username
	 * @param $password
	 * @param $role
	 *
	 * @return User
	 * @throws DuplicateNameException
	 */
	public function add( $username, $password, $role ) {

		$user = new Model\User();
		$user->setUsername( $username );
		$user->setPassword(Passwords::hash( $password ));
		$user->setRole( $role );
		try {
			$this->entityManager->persist( $user );
			$this->entityManager->flush(); // save it to the database
		}
		catch (Doctrine\DBAL\Exception\UniqueConstraintViolationException $exception){
			throw new DuplicateNameException();
		}

		$contact = new Model\Contact($user);

		$this->entityManager->persist($contact);
		$this->entityManager->flush(); // save it to the database

		return $this->entityManager->getRepository( Model\User::class )->findOneById( $user->getId() );
	}
}


class DuplicateNameException extends \Exception {
	public function __construct( $message = "User with that username already exists!" ) {
		parent::__construct( $message, 5, null );
	}
}

class BadTableNameException extends \Exception {
	public function __construct( $message = "Table with that users doesn't exists!" ) {
		parent::__construct( $message, 5, null );
	}
}

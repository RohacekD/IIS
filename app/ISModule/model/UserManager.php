<?php

namespace App\ISModule\Model;

use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{
	use Nette\SmartObject;

	const
		TABLE_NAME = 'Zamestnanec',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'login_Herec',
		COLUMN_PASSWORD_HASH = 'heslo',
		COLUMN_LOAD = 'uvazek',
		COLUMN_ROLE = 'role';


	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}


	/**
	 * @param array $credentials
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$row = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);
		$id = $arr[self::COLUMN_ID];
		unset($arr[self::COLUMN_ID]);
		$role = $arr[self::COLUMN_ROLE];
		unset($arr[self::COLUMN_ROLE]);

		return new Nette\Security\Identity($id, $role, $arr);
	}


	/**
	 * @param $username
	 * @param $password
	 * @param $role
	 * @param $load "Úvazek"
	 * @throws DuplicateNameException
	 */
	public function add($username, $password, $role, $load)
	{
		$row = $this->database->table(self::TABLE_NAME)->where(
			array(self::COLUMN_NAME => $username)
		)->count();
		if($row != 0){
			throw new DuplicateNameException;
		}

		try {
			$this->database->table(self::TABLE_NAME)->insert([
				self::COLUMN_NAME => $username,
				self::COLUMN_LOAD => $load,
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
				self::COLUMN_ROLE => $role,
			]);
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

}


class DuplicateNameException extends \Exception
{
	public function __construct($message = "User with that username already exists!")
	{
		parent::__construct($message, 5, NULL);
	}
}

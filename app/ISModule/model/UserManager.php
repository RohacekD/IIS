<?php

namespace App\ISModule\Model;

use Nette;
use Nette\Security\Passwords;
use Tracy\Debugger;


/**
 * Class UserManager
 * @package App\ISModule\Model
 */
class UserManager implements Nette\Security\IAuthenticator {
	const CONTACT_TABLE = "Kontakt";
	const CONTACT_COLUMN = "id_kontakt";
	use Nette\SmartObject;

	const
		TABLE_NAME = array(
		"Herec",
		"Reziser",
		"Organizator"
	),
		COLUMN_ID = 'login',
		COLUMN_NAME = 'login',
		COLUMN_PASSWORD_HASH = 'heslo';


	/** @var Nette\Database\Context */
	private $database;


	public function __construct( Nette\Database\Context $database ) {
		$this->database = $database;
	}


	/**
	 * @param array $credentials
	 *
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate( array $credentials ) {
		list( $username, $password ) = $credentials;
		$table_name = "";
		$row = null;

		foreach ( self::TABLE_NAME as $table ) {
			$row = $this->database->table( $table)->where( self::COLUMN_NAME, $username )->fetch();

			if ( ! $row ) {
				continue;
			}
			else{
				$table_name = $table;
				break;
			}
		}
		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}

		$arr = $row->toArray();
		unset( $arr[ self::COLUMN_PASSWORD_HASH ] );
		$id = $arr[ self::COLUMN_ID ];
		unset( $arr[ self::COLUMN_ID ] );
		$role = $this->tableToRole( $table_name );

		return new Nette\Security\Identity( $id, $role, $arr );
	}

	private function tableToRole( $table ) {
		$tables = array(
			"Herec"       => "actor",
			"Reziser"     => "director",
			"Organizator" => "organizer"
		);
		if ( ! array_key_exists( $table, $tables ) ) {
			throw new BadTableNameException;
		}

		return $tables[ $table ];
	}

	/**
	 * @param $username
	 * @param $password
	 * @param $role - Table to store data
	 *
	 * @throws DuplicateNameException
	 * @throws BadTableNameException
	 */
	public function add( $username, $password, $role ) {
		if ( ! $this->loginUnique( $username ) ) {
			throw new DuplicateNameException;
		}

		$table = $this->roleToTable( $role );


		try {
			$contact = $this->database->table( self::CONTACT_TABLE )->insert( [

			] );


			$this->database->table( $table )->insert( [
				self::COLUMN_NAME          => $username,
				self::COLUMN_PASSWORD_HASH => Passwords::hash( $password ),
				self::CONTACT_COLUMN       => $contact->getPrimary()
			] );
		} catch ( Nette\Database\UniqueConstraintViolationException $e ) {
			throw new DuplicateNameException;
		}
	}

	private function loginUnique( $username ) {
		foreach ( self::TABLE_NAME as $table ) {
			$row = $this->database->table( $table )->where(
				array( self::COLUMN_NAME => $username )
			)->count();
			if ( $row != 0 ) {
				return false;
			}
		}

		return true;
	}

	private function roleToTable($role){
		$tables = array(
			"actor" => "Herec",
			"director" => "Reziser",
			"organizer" => "Organizator"
		);
		if(!array_key_exists($role, $tables)){
			throw new BadTableNameException;
		}
		return $tables[$role];
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

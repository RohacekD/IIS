<?php
/**
 * Created by PhpStorm.
 * User: irimitenkan
 * Date: 17.6.14
 * Time: 22:14
 */

namespace App\Acl;

use Nette,
    Nette\Security\Permission;

class AclFactory{
    /**
	 * This class referencing UC-Diagram
     * @return Permission
     */
    public function createAcl(){
        $acl = new Permission;
		//create roles
        $acl->addRole('guest');
        $acl->addRole('actor', 'guest');

		$acl->addRole('director', 'guest');
		$acl->addRole('organizer', 'director');
		$acl->addRole('admin', 'organizer');

		//create resources
        $acl->addResource('productions');//inscenace
		$acl->addResource('performance');//predstaveni
		$acl->addResource('role');//role
		$acl->addResource('prop');//rekvizita
		$acl->addResource('employees');//zamestnanci/ucty

		//bind resources to roles
		//productions
		$acl->allow('organizer', "productions", array("view", "edit"));
		$acl->allow('actor', "productions", array("view"));
		//performance
		$acl->allow('director', "performance", array("view", "edit"));
		$acl->allow('actor', "performance", array("view"));
		//role
		//director can edit occupy etc
		$acl->allow('director', "role", array("view", "edit"));
		$acl->allow('actor', "role", array("view"));
		//prop
		$acl->allow('organizer', "prop", array("view", "edit"));
		$acl->allow('actor', "prop", array("view"));
		//employees
		$acl->allow('organizer', "employees", array("view", "edit"));
		$acl->allow('director', "employees", array("view"));
		//TODO: add every bindings


        return $acl;
    }
}
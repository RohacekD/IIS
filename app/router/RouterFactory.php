<?php

namespace App;

use Nette,
	App\Model,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route;


/**
 * Router factory.
 */
class RouterFactory extends Nette\Object {

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter() {
		//TODO: create sitemap and robots?
		$router   = new RouteList();
		$router[] = new Route( 'robots.txt', 'Robots:default' );
		$router[] = new Route( 'sitemap.xml', 'Sitemap:default' );
		$router[] = new Route( '[<locale=cs cs|en>/]index<? \.html?|\.php|>', 'Homepage:default', Route::ONE_WAY );
		$router[] = self::createIS();
		$router[] = new Route( '[<locale=cs cs|en>/]<presenter=Homepage>/<action=default>[/strana-<page>]',
			array(
				'presenter' => array(
					Route::FILTER_TABLE => array(
						'inscenace' => 'Productions'
					)
				),
				'page'      => 1,
			)
		);

		return $router;
	}

	public static function createIS() {
		$admin   = new RouteList( 'IS' );
		$admin[] = new Route( 'admin/index<? \.html?|\.php|>', 'Homepage:default', Route::ONE_WAY );
		$admin[] = new Route( 'admin/novinky/detail/<id>/', array(
			'presenter' => 'news',
			'action'    => 'show',
		) );
		$admin[] = new Route( 'admin/<presenter=Homepage>/<action=default>[/strana-<page>][/<id>]', array(
			'presenter' => array(
				Route::FILTER_TABLE => array(
					'inscenace'   => 'Productions',
					'hry'         => 'Plays',
					'role'        => 'Role',
					'zkousky'     => 'Rehearsals',
					'rekvizity'   => 'Properities',
					'predstaveni' => 'Performances',
					'chyba'       => 'Error',
					'uzivatele'   => 'Users',
					'prihlaseni'  => 'Sign',
					'nastaveni'   => 'Settings'
				)
			),
			'page'      => 1,
		) );

		return $admin;
	}
}

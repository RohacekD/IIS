<?php

namespace App;

use Nette,
	App\Model,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route;


/**
 * Router factory.
 */
class RouterFactory extends Nette\Object
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		//TODO: create sitemap and robots?
		$router = new RouteList();
		$router[] = new Route('robots.txt', 'Robots:default');
		$router[] = new Route('sitemap.xml', 'Sitemap:default');
		$router[] = new Route('index<? \.html?|\.php|>', 'Homepage:default', Route::ONE_WAY);
		$router[] = self::createIS();
		$router[] = new Route('<presenter=Homepage>/<action=default>[/strana-<page>]',
			array(
				'presenter' => array(
					Route::FILTER_TABLE => array(
						'o-nas'     => 'About',
						'produkty'  => 'Products',
						'kontakty'  => 'Contacts',
						'aktuality' => 'News',
						'prodejny'  => 'Store',

					)
				),
				'page' => 1,
			)
		);

		return $router;
	}

	public static function createIS()
	{
		$admin = new RouteList('IS');
		$admin[] = new Route('admin/index<? \.html?|\.php|>', 'Homepage:default', Route::ONE_WAY);
		$admin[] = new Route('admin/novinky/detail/<id>/',array(
			'presenter' => 'news',
			'action' => 'show',
		));
		$admin[] = new Route('admin/<presenter=Homepage>/<action=default>[/strana-<page>][/<id>]',array(
			'page' => 1,
		));
		return $admin;
	}
}

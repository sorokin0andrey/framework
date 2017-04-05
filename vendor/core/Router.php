<?php

namespace test\vendor\core;

/**
* Router
*/
class Router
{
	
	protected static $routes = [];
	protected static $route = [];

	public static function Add($uri, $route = [])
	{
		$uri = str_replace('{', '(?P<', $uri);
		$uri = str_replace('}', '>[a-z0-9-]+)', $uri);
		$uri = $uri . '$';
        $route['pattern'] = $uri;
		self::$routes[] = $route;
	}

	private static function matchRoute()
	{
		$url = rtrim(urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
		if(empty($url)) $url = '/';
		foreach (self::$routes as $route) {
		    $pattern = $route['pattern'];
			if(preg_match("#$pattern#i", $url, $matches) && self::getMethod($route['method'])) {
				self::$route = $route;
				self::$route['params'] = [];
				foreach ($matches as $key => $value) {
					if(is_string($key)) self::$route['params'][$key] = $value;
				}
				return true;
			}
		}
		return false;
	}


	public static function start()
	{
		if(self::matchRoute()) {
			$controller = 'test\\app\\Controllers\\'.self::$route['controller'];
			$action = self::$route['action'];
			$params = self::$route['params'];
			$params = array_merge($params, $_POST, $_GET);
			if(class_exists($controller)) {
				$cObj = new $controller;
				if(method_exists($cObj, $action)) {
					$cObj->$action($params);
				} else {
					dd('Method "'.$action.'" in is not exists!');
				}
			} else {
				dd('Class "'.$controller.'" is not exists!');
			}
		} else {
			http_response_code(404);
			echo '404';
		}
	}

	public static function getRoutes()
	{
		return self::$routes;
	}

	public static function getRoute()
	{
		return self::$route;
	}

	public static function getMethod($method)
	{
		if($method == 'any' || $method == strtolower($_SERVER['REQUEST_METHOD'])) return true;
		return false;
	}
}
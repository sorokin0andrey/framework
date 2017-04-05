<?php

namespace test\app\Controllers;

use test\app\Views\View;

/**
* Basic Controller
*/
abstract class Controller
{
	public $view;
	
	function __construct()
	{
		$this->view = new View;
        $user = AuthController::AuthUser();
        $auth = AuthController::Auth();
        $this->view->setVars(compact('user', 'auth'));
	}
}
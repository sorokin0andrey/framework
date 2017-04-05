<?php

namespace test\app\Controllers;
use test\app\Models\Post;
use test\app\Models\User;


/**
* PagesController
*/
class PagesController extends Controller
{
	public function index()
	{
	    $users = User::select()->all();
        $this->view->render('Pages/index', 'title', compact('users'));
	}
}
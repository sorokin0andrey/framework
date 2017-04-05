<?php
session_start();
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../vendor/core/functions.php';


use test\vendor\core\Router;

//Router

Router::Add('/', ['method' => 'any', 'controller' => 'PagesController', 'action' => 'index']);
Router::Add('/login', ['method' => 'get', 'controller' => 'AuthController', 'action' => 'getLogin']);
Router::Add('/login', ['method' => 'post', 'controller' => 'AuthController', 'action' => 'postLogin']);
Router::Add('/logout', ['method' => 'any', 'controller' => 'AuthController', 'action' => 'logout']);

Router::start();
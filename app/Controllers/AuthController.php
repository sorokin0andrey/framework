<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.03.2017
 * Time: 17:00
 */

namespace test\app\Controllers;

use test\app\Models\User;


class AuthController extends Controller
{
    public static function Auth()
    {
        if (isset($_SESSION['logged_user'])) return true;
        return false;
    }

    public static function AuthUser()
    {
        if (self::Auth()) {
            return User::select()->where('id', $_SESSION['logged_user'])->first();
        }
        return false;
    }

    public function getLogin()
    {
        $this->view->render('Auth/login', 'Login');
    }

    public function postLogin($params)
    {
        $user = User::select()->where('login', $params['name'])->first();
        if($user) {
            if(password_verify($params['password'], $user->password)) {
                $_SESSION['logged_user'] = $user->id;
                redirect('/');
                return;
            } else $error = 'Неверный пароль!';
        } else $error = 'Пользователь с данным ником не существует!';
        $this->view->render('Auth/login', 'Login', compact('error', 'params'));
    }

    public function logout()
    {
        unset($_SESSION['logged_user']);
        return redirect('/');
    }
}
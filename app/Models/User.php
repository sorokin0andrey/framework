<?php

namespace test\app\Models;

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.03.2017
 * Time: 21:10
 */
class User extends Model
{
    public static $table = 'users';

    public static $available = ['name', 'password'];
}
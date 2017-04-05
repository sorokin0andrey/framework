<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.03.2017
 * Time: 1:41
 */

namespace test\app\Models;


class Post extends Model
{
    public static $table = 'posts';

    public static $available = ['title'];
}
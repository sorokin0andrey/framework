<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit383eaab061891b794fa4a7d43397821f
{
    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'test\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'test\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit383eaab061891b794fa4a7d43397821f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit383eaab061891b794fa4a7d43397821f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
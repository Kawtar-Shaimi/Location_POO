<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit56754a9c184630e8973e91d4e2497177
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'User\\LocationPoo\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'User\\LocationPoo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit56754a9c184630e8973e91d4e2497177::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit56754a9c184630e8973e91d4e2497177::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit56754a9c184630e8973e91d4e2497177::$classMap;

        }, null, ClassLoader::class);
    }
}

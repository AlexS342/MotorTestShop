<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit99269a868b7dc0957e7a3952829f2a93
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Shilov\\Shop\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Shilov\\Shop\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit99269a868b7dc0957e7a3952829f2a93::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit99269a868b7dc0957e7a3952829f2a93::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit99269a868b7dc0957e7a3952829f2a93::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita5be8e973e58e9d0227e399bf8503b74
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SOLID\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SOLID\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInita5be8e973e58e9d0227e399bf8503b74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita5be8e973e58e9d0227e399bf8503b74::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita5be8e973e58e9d0227e399bf8503b74::$classMap;

        }, null, ClassLoader::class);
    }
}

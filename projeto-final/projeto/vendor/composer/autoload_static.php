<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84f7d924467c7533d9d420b4e29f9018
{
    public static $prefixLengthsPsr4 = array (
        'v' => 
        array (
            'voku\\' => 5,
        ),
        'P' => 
        array (
            'Praetorian\\Slugger\\' => 19,
        ),
        'C' => 
        array (
            'Code\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'voku\\' => 
        array (
            0 => __DIR__ . '/..' . '/voku/portable-ascii/src/voku',
            1 => __DIR__ . '/..' . '/voku/stop-words/src/voku',
        ),
        'Praetorian\\Slugger\\' => 
        array (
            0 => __DIR__ . '/..' . '/praetoriantechnology/php-slugger/src',
        ),
        'Code\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'URLify' => 
            array (
                0 => __DIR__ . '/..' . '/jbroadway/urlify',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84f7d924467c7533d9d420b4e29f9018::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84f7d924467c7533d9d420b4e29f9018::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit84f7d924467c7533d9d420b4e29f9018::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit84f7d924467c7533d9d420b4e29f9018::$classMap;

        }, null, ClassLoader::class);
    }
}

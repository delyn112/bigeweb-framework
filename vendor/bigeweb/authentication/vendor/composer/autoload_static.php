<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf8dfb1a9464050344662ce79f44e31e
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bigeweb\\Authentication\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bigeweb\\Authentication\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf8dfb1a9464050344662ce79f44e31e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf8dfb1a9464050344662ce79f44e31e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaf8dfb1a9464050344662ce79f44e31e::$classMap;

        }, null, ClassLoader::class);
    }
}

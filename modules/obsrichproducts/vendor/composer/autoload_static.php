<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82ab33f7afd372f451fcdeadb615dfd5
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OBSolutions\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OBSolutions\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Obsrichproducts' => __DIR__ . '/../..' . '/obsrichproducts.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit82ab33f7afd372f451fcdeadb615dfd5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit82ab33f7afd372f451fcdeadb615dfd5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit82ab33f7afd372f451fcdeadb615dfd5::$classMap;

        }, null, ClassLoader::class);
    }
}

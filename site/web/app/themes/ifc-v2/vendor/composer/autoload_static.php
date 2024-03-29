<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0567bf13b81f61516f2d2adde6739bbf
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/..' . '/vladkens/autoprefixer/lib',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0567bf13b81f61516f2d2adde6739bbf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0567bf13b81f61516f2d2adde6739bbf::$prefixDirsPsr4;
            $loader->fallbackDirsPsr0 = ComposerStaticInit0567bf13b81f61516f2d2adde6739bbf::$fallbackDirsPsr0;

        }, null, ClassLoader::class);
    }
}

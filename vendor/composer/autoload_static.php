<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita4e9e3809e8f58e2b9e7d653481801d7
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Predis\\' => 7,
        ),
        'M' => 
        array (
            'MirazMac\\DeepFry\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
        'MirazMac\\DeepFry\\' => 
        array (
            0 => __DIR__ . '/..' . '/mirazmac/php-deep-fry/src',
        ),
    );

    public static $classMap = array (
        'BenFryer\\BenFryer' => __DIR__ . '/../..' . '/src/BenFryer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita4e9e3809e8f58e2b9e7d653481801d7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita4e9e3809e8f58e2b9e7d653481801d7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita4e9e3809e8f58e2b9e7d653481801d7::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit19484613ca2125ace423a95a46b69232
{
    public static $files = array (
        '6632f90381dd49c5fe745d09406b9abb' => __DIR__ . '/..' . '/htmlburger/carbon-field-number/field.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Squidge\\' => 8,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
            'Carbon_Fields\\' => 14,
            'Carbon_Field_Number\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Squidge\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
        'Carbon_Field_Number\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-field-number/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit19484613ca2125ace423a95a46b69232::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit19484613ca2125ace423a95a46b69232::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit19484613ca2125ace423a95a46b69232::$classMap;

        }, null, ClassLoader::class);
    }
}
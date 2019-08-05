<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit900da647cd69851e0f266b4f597faffb
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit900da647cd69851e0f266b4f597faffb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit900da647cd69851e0f266b4f597faffb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

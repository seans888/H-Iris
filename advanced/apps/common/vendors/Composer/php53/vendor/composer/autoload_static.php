<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite6517c12aa7218d2ea801bc0157929ec
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
        'Z' => 
        array (
            'Zend\\Validator\\' => 15,
            'Zend\\Uri\\' => 9,
            'Zend\\Stdlib\\' => 12,
            'Zend\\ServiceManager\\' => 20,
            'Zend\\Mime\\' => 10,
            'Zend\\Math\\' => 10,
            'Zend\\Mail\\' => 10,
            'Zend\\Loader\\' => 12,
            'Zend\\Http\\' => 10,
            'Zend\\Escaper\\' => 13,
            'Zend\\Crypt\\' => 11,
        ),
        'T' => 
        array (
            'Twig\\' => 5,
            'Tipimail\\' => 9,
        ),
        'P' => 
        array (
            'PhpAmqpLib\\' => 11,
        ),
        'D' => 
        array (
            'Dyn\\' => 4,
        ),
        'C' => 
        array (
            'Cron\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'Zend\\Validator\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-validator/src',
        ),
        'Zend\\Uri\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-uri/src',
        ),
        'Zend\\Stdlib\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-stdlib/src',
        ),
        'Zend\\ServiceManager\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-servicemanager/src',
        ),
        'Zend\\Mime\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-mime/src',
        ),
        'Zend\\Math\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-math/src',
        ),
        'Zend\\Mail\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-mail/src',
        ),
        'Zend\\Loader\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-loader/src',
        ),
        'Zend\\Http\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-http/src',
        ),
        'Zend\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-escaper/src',
        ),
        'Zend\\Crypt\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-crypt/src',
        ),
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Tipimail\\' => 
        array (
            0 => __DIR__ . '/..' . '/tipimail/tipimail',
        ),
        'PhpAmqpLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-amqplib/php-amqplib/PhpAmqpLib',
        ),
        'Dyn\\' => 
        array (
            0 => __DIR__ . '/..' . '/dyninc/dyn-php/src',
        ),
        'Cron\\' => 
        array (
            0 => __DIR__ . '/..' . '/mtdowling/cron-expression/src/Cron',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'S' => 
        array (
            'Sendinblue' => 
            array (
                0 => __DIR__ . '/..' . '/mailin-api/mailin-api-php/src',
            ),
        ),
        'M' => 
        array (
            'Mandrill' => 
            array (
                0 => __DIR__ . '/..' . '/mandrill/mandrill/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite6517c12aa7218d2ea801bc0157929ec::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite6517c12aa7218d2ea801bc0157929ec::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite6517c12aa7218d2ea801bc0157929ec::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}

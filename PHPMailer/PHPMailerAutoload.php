<?php
/**
 * PHPMailer SPL autoloader.
 * PHP Version 5
 * @package PHPMailer
 */

function PHPMailerAutoload($classname)
{
    $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'class.' . strtolower($classname) . '.php';
    if (is_readable($filename)) {
        require $filename;
    }
}

// Utilise spl_autoload_register() pour enregistrer le chargeur automatique
if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    // SPL autoloading a été introduit dans PHP 5.1.2
    spl_autoload_register('PHPMailerAutoload');
} else {
    // Fallback pour les anciennes versions de PHP
    spl_autoload_register(function ($classname) {
        $filename = __DIR__ . '/' . str_replace('\\', '/', $classname) . '.php';
        include($filename);
    });
 }    
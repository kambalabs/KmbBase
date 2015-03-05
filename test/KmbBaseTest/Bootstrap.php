<?php
namespace KmbBaseTest;

use Zend\Stdlib\ArrayUtils;

require __DIR__ . '/AbstractBootstrap.php';

class Bootstrap extends AbstractBootstrap
{
    public static function getApplicationConfig()
    {
        return ArrayUtils::merge(
            parent::getApplicationConfig(),
            array(
                'module_listener_options' => array(
                    'config_glob_paths' => array(
                        dirname(__DIR__) . '/{,*.}{global,local}.php',
                    ),
                ),
            )
        );
    }
}

Bootstrap::init();
Bootstrap::chroot();

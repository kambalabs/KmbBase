<?php
namespace KmbBaseTest;

use RuntimeException;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Test bootstrap, for setting up autoloading
 */
abstract class AbstractBootstrap
{
    protected static $serviceManager;

    /**
     * Get the root path of the module.
     * Usually : dirname(dirname(__DIR__))
     * @return string
     */
    public static function rootPath()
    {
        return dirname(dirname(__DIR__));
    }

    public static function init()
    {
        error_reporting(E_ALL | E_STRICT);
        \Locale::setDefault('en_US');
        date_default_timezone_set('Europe/Paris');

        static::initAutoloader();

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', static::getApplicationConfig());
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    public static function chroot()
    {
        chdir(static::rootPath());
    }

    /**
     * Provides basic Application Config
     *
     * @return array
     */
    public static function getApplicationConfig()
    {
        $zf2ModulePaths = array();
        if (($path = static::findParentPath('kambalabs'))) {
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath('vendor'))) {
            $zf2ModulePaths[] = $path;
        }

        // use ModuleManager to load this module and it's dependencies
        return array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths,
            ),
            'modules' => array(
                'KmbBase'
            )
        );
    }

    /**
     * Provides specific namespace paths for the module
     *
     * @return array
     */
    public static function getNamespacePaths()
    {
        return array(
            __NAMESPACE__ => __DIR__,
        );
    }

    /**
     * @return ServiceManager
     */
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        $zf2Path = $vendorPath . '/zendframework/zendframework/library';
        if (!is_dir($zf2Path)) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install`.'
            );
        }

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => static::getNamespacePaths(),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = static::rootPath();
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

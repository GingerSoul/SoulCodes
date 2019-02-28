<?php

use Dhii\Di\ContainerAwareCachingContainer;
use Dhii\Cache\MemoryMemoizer;
use GingerSoul\SoulCodes\Plugin;

/**
 * The function that bootstraps the application.
 *
 * @since [*next-version*]
 */
return function ($appRootPath, $appRootUrl) {

    $appRootDir = dirname($appRootPath);

    if (file_exists($autoload = "$appRootDir/vendor/autoload.php")) {
        require_once($autoload);
    }

    $servicesFactory = require_once("$appRootDir/includes/services.php");
    $c = new ContainerAwareCachingContainer(
        $servicesFactory($appRootPath, $appRootUrl),
        new MemoryMemoizer()
    );

    $plugin = $c->get('plugin');
    assert($plugin instanceof Plugin);

    return $plugin;
};

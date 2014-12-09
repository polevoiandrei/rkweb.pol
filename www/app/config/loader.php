<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

//Register some namespaces
$loader->registerNamespaces(
    array(
       "MegaCurl" => $config->application->vendorsDir."MegaCurl/",
       "RKWeb" => $config->application->libraryDir."RKWeb/"
    )
)->register();



$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        // $config->application->vendorsDir
    )
)->register();

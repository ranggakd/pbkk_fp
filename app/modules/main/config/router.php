<?php

/**
 * Custom Router
 *
 * @var array $module
 * @var string $moduleName
 */

$webNamespace = $module['namespace']['webController'];
$apiNamespace = $module['namespace']['apiController'];

/**
 *
 * Example
 *
 * $router->add('/test', [
 *      'namespace' => $webNamespace,       // $webNamespace or $apiNamespace
 *      'module' => $moduleName,            // Keep it default
 *      'controller' => 'test,
 *      'action' => 'delete',
 *      'params'=> 1
 * ]);
 *
 */

// additional
$router->add('/signin',array(
    'namespace' => $webNamespace,
    'module' => $moduleName,
    'controller' => 'auth',
    'action' => 'signIn',
));

$router->add('/signup',array(
    'namespace' => $webNamespace,
    'module' => $moduleName,
    'controller' => 'auth',
    'action' => 'signUp',
));

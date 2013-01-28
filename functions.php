<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

function {{THEME_NAME}}Autoloader($className)
{
    $paths = array(
        'src/'
    );

    if (stripos($className, "{{THEME_NAMESPACE}}") === false) {
        return;
    }

    foreach ($paths as $path) {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }
}

spl_autoload_register('{{THEME_NAME}}Autoloader');

global ${{THEME_NAME}};

${{THEME_NAME}} = new {{THEME_NAMESPACE}}_{{THEME_NAME}}_{{THEME_NAME}}(); // PHP 5.2
// ${{THEME_NAME}} = new {{THEME_NAMESPACE}}\{{THEME_NAME}}\{{THEME_NAME}}(); // PHP 5.3

${{THEME_NAME}}->initialize();

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
        $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($filename)) {
            return require $filename;
        }
    }
}

spl_autoload_register('{{THEME_NAME}}Autoloader');

global ${{THEME_NAME}};

${{THEME_NAME}} = new {{THEME_NAMESPACE}}_{{THEME_NAME}}_{{THEME_NAME}}();

${{THEME_NAME}}->initialize();

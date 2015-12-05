<?php

/*
|--------------------------------------------------------------------------
| Set uncaught Exception handler
|--------------------------------------------------------------------------
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mb_regex_encoding('UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
/*
|--------------------------------------------------------------------------
| Start session
|--------------------------------------------------------------------------
*/
session_start();

/*
|--------------------------------------------------------------------------
| Set uncaught Exception handler
|--------------------------------------------------------------------------
*/
function exception_handler($exception) {
    echo $exception->getMessage();
}

set_exception_handler('exception_handler');

/*
|--------------------------------------------------------------------------
| Autoload classes
|--------------------------------------------------------------------------
*/
function my_autoloader($class) {
    require_once 'classes/' . $class . '.php';
}

spl_autoload_register('my_autoloader');

/*
|--------------------------------------------------------------------------
| Connect to DB
|--------------------------------------------------------------------------
*/
$db = new DB('mysql', 'localhost', 'hangman', 'root', 'root');

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
*/
function buildView($viewName, array $vars = []) {
    //import variables into function scope
    extract($vars);

    require_once $_SERVER['DOCUMENT_ROOT'].'/views/includes/header.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/views/$viewName.php";
    require_once $_SERVER['DOCUMENT_ROOT'].'/views/includes/footer.php';
}

function mb_str_split( $string ) {
    # Split at all position not after the start: ^
    # and not before the end: $
    return preg_split('/(?<!^)(?!$)/u', $string );
}

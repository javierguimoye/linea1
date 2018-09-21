<?php

//exit(md5('demo'));
// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: *');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

use Inc\Route;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

date_default_timezone_set('America/Lima');
header("Content-type: text/html; charset=UTF-8");

define('_PATH_', dirname(__FILE__) . '/'); // Directorio Base

require _PATH_ . 'vendor/autoload.php';
require _PATH_ . 'inc/helpers.php';

$route = new Route();
$route->add(':any', '%', '%');
$route->send();

if (_IS_LOCAL_) {
    usleep(500000);
}
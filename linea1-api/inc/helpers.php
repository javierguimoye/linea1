<?php

use Inc\Auth;
use Inc\Rsp;
use Inc\STG;
use Inc\Util;
use Inc\View;

define('_IS_LOCAL_', in_array(substr($_SERVER['REMOTE_ADDR'], 0, 4), ['127.', '::1', '192.']));
define('_IS_BETA_', ($_SERVER['SERVER_NAME'] == 'beta.focusit.pe'));
define('_IS_LIVE_', ($_SERVER['SERVER_NAME'] == '174.138.80.40'));

if (_IS_LOCAL_) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'linea1');
    define('URL_BASE', 'http://' . $_SERVER['HTTP_HOST'] . '/linea1-api/');

} else if (_IS_LIVE_) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'mi201000');
    define('DB_NAME', 'linea1');

    define('URL_BASE', 'http://beta.focusit.pe/linea-1/api/');

} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'focusit00');
    define('DB_NAME', 'linea1');

    define('URL_BASE', 'http://beta.focusit.pe/linea-1/api/');
}



/* Metodo GET */
function _GET($name, $default_value = '')
{
    $val = @trim(@$_GET[$name]);
    return !empty($val) ? $val : $default_value;
}

function _GET_DATE($name, $default_value = '')
{
    $val = @trim(@$_GET[$name]);
    return !empty($val) && Util::isDate($val) ? $val : $default_value;
}

function _GET_INT($name, $default_value = 0)
{
    $val = @$_GET[$name];
    return is_numeric($val) ? $val : $default_value;
}

/* Metodo POST */
function _POST($name, $default_value = '')
{
    $val = @trim(@$_POST[$name]);
    return !empty($val) ? $val : $default_value;
}

function _POST_DATE($name, $default_value = '')
{
    $val = @trim(@$_POST[$name]);
    return !empty($val) && Util::isDate($val) ? $val : $default_value;
}

function _POST_INT($name, $default_value = 0)
{
    $val = @$_POST[$name];
    return is_numeric($val) ? $val : $default_value;
}

function _POST_ARR($name, $default_value = [])
{
    $val = @$_POST[$name];
    return is_array($val) ? $val : $default_value;
}

/* Metodo REQUEST */
function _REQ($name, $default_value = '')
{
    $val = @trim(@$_REQUEST[$name]);
    return !empty($val) ? $val : $default_value;
}

function _REQ_DATE($name, $default_value = '')
{
    $val = @trim(@$_REQUEST[$name]);
    return !empty($val) && Util::isDate($val) ? $val : $default_value;
}

function _REQ_INT($name, $default_value = 0)
{
    $val = @$_REQUEST[$name];
    return is_numeric($val) ? $val : $default_value;
}

function _REQ_ARR($name, $default_value = [])
{
    $val = @$_REQUEST[$name];
    return is_array($val) ? $val : $default_value;
}

/**
 * @param $name : ejm: Namespace\Class
 * @return string
 */
function real_class($name)
{
    if ($pos = strrpos($name, '\\')) {
        $name = substr($name, $pos + 1);
    }
    return $name;
}

function view($name = null, $title_or_vars = null)
{
    $view = new View();
    if (is_null($name)) {
        $view->name(\Controllers\_controller::$module);
    } else {
        $view->name($name);
    }

    if (is_string($title_or_vars)) {
        $view->title($title_or_vars);
    } else if (is_array($title_or_vars)) {
        foreach ($title_or_vars as $k => $v) {
            $view->set($k, $v);
        }
    }

    return $view;
}

function rsp($p1 = null, $p2 = null)
{
    $rsp = new Rsp();

    if (is_bool($p1)) {
        $rsp->set('ok', $p1);
    } else if (!is_null($p1)) {
        $rsp->set('msg', $p1);
    }

    if (is_bool($p2)) {
        $rsp->set('ok', $p2);

    } else if (!is_null($p2)) {
        $rsp->set('msg', $p2);
    }

    return $rsp;
}

/**
 * Obtener total, obtener uno u asignar setting
 * @param string $name : si es nulo, asumiremos que quiere obtener todo
 * @param mixed $value : si no es nulo, asumiremos que se quiere asignar un valor
 * @return mixed
 */
function stg($name = null, $value = null)
{
    if (is_null($value)) {
        return STG::get($name);
    } else {
        return STG::set($name, $value);
    }
}

/**
 * @param $text
 * @param bool $force_api
 */
function done($text, $force_api = false)
{
    if ($force_api || Auth::isAPI()) {
        Util::done_rsp($text);
    } else {
        Util::done_view($text);
    }
}
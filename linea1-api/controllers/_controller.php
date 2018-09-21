<?php namespace Controllers;

use Inc\Auth;
use Inc\Perms;
use Inc\Route;
use Inc\STG;
use Inc\Util;

class _controller
{

    public static $module = null;

    // Cuando el login es requerido, por defecto todos los metodos necesitan permisos de lectura y escritura
    // ...excepto los que esten en las listas siguientes: $no_see,$no_edit
    protected $no_see = []; // No necesitan permisos de lectura
    protected $no_edit = ['index', 'item']; // No necesitan permisos de escritura

    /**
     * Constructor
     * @param bool $auth_required : Determina si se requiere el inicio de sesión
     */
    public function __construct($auth_required = true)
    {
        self::$module = real_class(static::class);

        if ($auth_required) {

            if (Auth::init()) {

                if (self::$module != '_controller' && self::$module != 'verify') {

                    if (!Auth::enabled())
                        done('not_enabled');

                    if (!in_array(Route::$method, $this->no_see) && !Perms::see())
                        done('not_readable');

                    if (!in_array(Route::$method, $this->no_edit) && !Perms::can())
                        done('not_authorized');

                }

            } else {

                if (Auth::isAPI()) {
                    Util::done_rsp('not_logged');
                } else {
                  Util::redirect('login?r=' . base64_encode($_SERVER['REQUEST_URI']));
                }

            }
        }

        STG::set('module', self::$module);
        STG::set('url_home', Perms::home());
        STG::set('can_edit', Perms::can());
    }

    public function setModule($module)
    {
        self::$module = $module;
    }

    // Error UI
    public function goHome()
    {
        header('Location: ' . Perms::home());
    }

}
<?php namespace Inc;

use Controllers\_controller;
use Libs\Pixie\QB;

class Perms
{

    /* @var Perms */
    private static $ins;

    public static function ins()
    {
        if (!static::$ins) static::$ins = new static;
        return static::$ins;
    }

    private $home = 'home';
    private $menu = [];
    private $current_module = null;

    public function __construct()
    {
        $this->loadPerms();
    }

    public function loadPerms()
    {
        if (Auth::logged()) {

            $menus = QB::table('perms pe')
                ->select(
                    'mo.id',
                    'mo.name',
                    'mo.url',
                    'mo.icon',
                    'pe.see',
                    'mo.id_parent',
                    'pe.edit',
                    'pe.home',
                    'pe.shortcut'
                )
                ->join('modules mo', 'mo.id', '=', 'pe.id_module')
                ->where('pe.id_role', Auth::user()->id_role)
                ->where('mo.state', 1)
                ->orderBy('mo.sort')
                ->get();

            if ($menus) {
                foreach ($menus as $menu) {
                    $this->menu[] = $menu;
                    if ($menu->home == 1) $this->home = $menu->url;
                    // Modulo Actual
                    if ($menu->url == _controller::$module) {
                        $this->current_module = $menu;
                    }
                }
            }
        }
    }

    /**
     * @return \stdClass|null
     */
    public static function current()
    {
        return self::ins()->current_module;
    }

    /**
     * @param $module
     * @return \stdClass|null
     */
    public static function getItem($module)
    {
        foreach (self::ins()->menu as $item) {
            if ($item->url == $module) {
                return $item;
            }
        }
        return null;
        //return isset(self::ins()->menu[$module]) ? self::ins()->menu[$module] : null;
    }

    /***
     * Saber si tiene permiso de lectura
     * @param null|string $module : si envia NULL se refiere al modulo actual
     * @return bool
     */
    public static function see($module = null)
    {
        $mod = $module ? self::getItem($module) : self::current();
        return Auth::root() || ($mod && $mod->see == 1);
    }

    /***
     * Saber si tiene permiso de escritura
     * @param null|string $module : si envia NULL se refiere al modulo actual
     * @return bool
     */
    public static function can($module = null)
    {
        $mod = $module ? self::getItem($module) : self::current();
        return Auth::root() || ($mod && $mod->edit == 1);
    }

    /* @return string : url de inicio */
    public static function home()
    {
        return self::ins()->home;
    }

    /* @return array : Menu principal */
    public static function menu()
    {
        $items = [];
        foreach (self::ins()->menu as $item) {
            if ($item->see == 1) {
                $item->active = $item->url == _controller::$module;
                $items[] = $item;
            }
        }
        return $items;
    }

    public static function menuSorted()
    {
        return Util::ordMenu(self::menu());
    }

    /* @return array : Accesos directo */
    public static function shortcuts()
    {
        $items = [];
        foreach (self::ins()->menu as $item) {
            if ($item->shortcut == 1) {
                $item->active = $item->url == _controller::$module;
                $items[] = $item;
            }
        }
        return $items;
    }
}
<?php namespace Inc;

use Models\Setting;

class STG extends \stdClass {

    public $session_key     = 'session_reserver';
    public $module          = '';
    public $url_base        = URL_BASE;

    private static $ins;
    static function ins(){
        if(!self::$ins){
            self::$ins = new self();
            $os = Setting::all('name','value');
            foreach($os as $o){
                self::$ins->{$o->name} = $o->value;
            }
        }
        return self::$ins;
    }

    static function get($name){
        return self::ins()->$name;
    }

    static function bool($name){
        return self::get($name)== 1;
    }

    static function num($name){
        return self::get($name) + 0;
    }

    static function set($name, $value){
        return self::ins()->$name = $value;
    }

    static function all(){
        return self::ins();
    }

}
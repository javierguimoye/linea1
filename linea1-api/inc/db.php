<?php namespace Inc;

use Libs\Pixie\QB;

class DB{

    /** @var DB */
    private static $ins;
    public static function ins(){
        if(!static::$ins) static::$ins = new static();
        return static::$ins;
    }

	public function __construct(){

	}

	//...

    /* @var \PDO */
    protected static $cn;
	public static function cn(){
        if(!static::$cn){
            static::$cn = new \PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST, DB_USER, DB_PASS);
            static::$cn->prepare("SET NAMES 'utf8'")->execute();
        }
        return static::$cn;
    }

    /* @var \PDO */
    public static function getCN()
    {
        return  self::$cn;
    }

    //...
    public static function table($table){
	    return QB::table($table);
    }

	//...
	public static function arr($sql, $col = null, $val = null){
        if(!is_null($val))
        {
            return QB::table($sql)->where($col,'=',$val)->get();
        }
        else if(!is_null($col))
        {
            return QB::table($sql)->where('id','=',$col)->get();
        }
        else if(strpos($sql,' ') === false)
        {
            return QB::table($sql)->where('state','=',1)->get();
        }
        else {
            return QB::query($sql)->get();
        }
	}

	//...
	public static function o($sql, $col = null, $val = null){
	    $items = self::arr($sql, $col, $val);
	    return is_array($items) && count($items) > 0 ? $items[0] : null;
	}

	//...
	public static function has($sql, $col = null, $val = null){
	    return self::total($sql, $col, $val) > 0;
	}

	//...
	public static function total($sql, $col = null, $val = null){
        $items = self::arr($sql, $col, $val);
        return is_array($items) ? count($items) : 0;
	}

	//...
	public static function query($sql, $bindings = null)
    {
        if(!is_array($bindings)){
            $bindings = func_get_args();
            array_splice($bindings,0,1);
        }
	    return QB::query($sql, $bindings);
	}

	//...
	public static function insert($table, $data){
	    return QB::table($table)->insert($data);
	}

	//...
	public static function update($table, $data, $id){
	    return QB::table($table)->where('id','=',$id)->update($data);
	}

	//...
	public static function lastID(){
	    return (int) self::cn()->lastInsertId();
	}

}
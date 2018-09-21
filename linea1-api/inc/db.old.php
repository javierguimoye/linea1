<?php class DB_old{

    /** @var DB */
    private static $ins;
    public static function ins(){
        if(!static::$ins) static::$ins = new static();
        return static::$ins;
    }

    /** @var mysqli */
	private $cn;

	public function __construct(){
        $this->cn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->cn->connect_error)
        {
            die("Error en la conexion : ".$this->cn->connect_errno."-".$this->cn->connect_error);
        }
        else
        {
            mysqli_set_charset($this->cn, "utf8");
            $this->cn->query("SET @@session.time_zone='-05:00';");
        }
	}

	public static function cn(){
	    return DB::ins()->cn;
    }

	/**
	 * Obtener registros desde una consulta SQL
	 * @param $sql :: sentencia sql
	 * @return mysqli_result | boolean
	 */
	public static function get($sql, $col = null, $val = null){
		if(!is_null($val))
		{
			$sql = "SELECT * FROM $sql WHERE $col = '$val'";
		}
		else if(!is_null($col))
		{
			$sql = "SELECT * FROM $sql WHERE id = $col";
		}
		else if(strpos($sql,' ') === false)
		{
            $sql = "SELECT * FROM $sql WHERE state = 1";
        }
		return DB::query($sql);
	}

	// Obtener array de arrays
	public static function arr($sql, $col = null, $val = null){
		$items = [];
		if($os = DB::get($sql, $col, $val)){
			while($o = $os->fetch_object()){
				$items[] = $o;
			}
		}
		return $items;
	}

	/**
	 * Obtener UN registro desde mysql, en objeto
	 * @return: object
	 */
	public static function o($sql, $col = null, $val = null){
		$result = DB::get($sql, $col, $val);
		return $result ? $result->fetch_object() : false;
	}

	/**
	 * Obtener UN registro desde mysql, en array
	 * @param: Sentencia SQL
	 * @return array|bool Mysql
	 */
	public static function a($sql, $col = null, $val = null){
		$result = DB::get($sql, $col, $val);
		return $result ? $result->fetch_assoc() : false;
	}

	/**
	 * Saber si una consulta obtuvo resultados
	 * @param $table :: de pasar solo un parametro, se considera sentencia SQL
	 * @param $table, $column, $data :: de pasar los 3 parametros, se considera consulta rapida
	 * @return true | false
	 */
	public static function has($sql, $col = null, $val = null){
		return DB::total($sql, $col, $val) > 0;
	}

	/**
	 * Retorna el total de resultados en una consulta
	 * @param $sql :: sentencia SQL
	 * @return int número
	 */
	public static function total($sql, $col = null, $val = null){
		$query = DB::get($sql, $col, $val);
		return $query ? $query->num_rows : 0;
	}

	/**
	 * Ejecuta una sentencia SQL
	 */
	public static function query($sql){
	    //echo $sql.'<hr>';
		return DB::cn()->query($sql);
	}

	/**
	 * Insertar valores en determinada tabla
	 * @param $table :: tabla a insertar
	 * @param $data :: array con los datos SQL
	 * @return boolean resultado de la ejecusion
	 */
	public static function insert($table, $data){
		$VALS = '';
		foreach($data as $key => $value){
			if($value != 'NOW()'){
				$value = "'".DB::cn()->real_escape_string($value)."'";
			}
			$VALS .= $key." = $value,";
		}
		$VALS = trim($VALS, ',');
		$SQL = "INSERT INTO $table SET $VALS";
		return DB::query($SQL);
	}

	/**
	 * @param $table
	 * @param $data array
	 * @param $where string|int Si asigna un numero, se entendera que es el ia, y sera ID=$where
	 * @return bool|mysqli_result
	 */
	public static function update($table, $data, $where){
		$VALS = '';
		foreach($data as $key => $value){
			$value = DB::cn()->real_escape_string($value);
			$VALS .= $key." = ".($value == 'NOW()' || $value=='NULL' ? $value : "'$value'" ).",";
		}
		$VALS = trim($VALS, ',');
		if(is_numeric($where) && $where > 0){
			$where = "id=$where";
		}
		// Validar que el campo WHERE no este vacio
		if(!empty($where) && $where != ''){
			$SQL = "UPDATE $table SET $VALS WHERE $where";
			return DB::query($SQL);
		} else {
			return false;
		}
	}

	/**
	 * Obtener el último ID insertado
	 */
	public static function lastID(){
		return DB::cn()->insert_id;
	}

	/**
	 * Escape String
	 */
	public static function escape($value){
		return DB::cn()->real_escape_string($value);
	}

}
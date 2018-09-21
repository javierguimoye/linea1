<?php namespace Inc;

use DateTime;
use InvalidArgumentException;

class Util{

    public static function done_rsp($text = null){
        header('Content-Type: application/json');
        exit(json_encode(rsp($text)));
    }

    public static function done_view($text = null){
        exit(view('e404')->set('text', $text));
    }

    public static function redirect($uri){
        header('Location: '.URL_BASE.$uri);
        exit;
    }

    /**
     * Enviar mensaje Push
     * @param string | array $token
     * @param string $type
     * @param mixed $title
     * @param string $content
     * @return bool
     */
	public static function sendPush($token, $type, $title, $content = ''){
	    include_once('push.php');
        $push = new Push();
        $push->setType($type);
        $push->setTitle($title);
        $push->setContent($content);
        $push->setTokens($token);
        $push->send();
        return $push->getStatus();
    }

	// Calcular edad desde una fecha
	public static function calcAge($date, $formato = '%y'){
		$today = new DateTime();
		$birthdate = new DateTime($date);
		$interval = $today->diff($birthdate);
		return $interval->format($formato);
	}

	// Metros a Kilometros
	public static function parseMeters($m){
		return round($m/1000, 1).' KM';
	}
	
	// Convertir segundos a x tiempo
	public static function parseDuration($seconds){
		$minutes = floor($seconds / 60);
		return sprintf("%02d", $minutes).' MIN';
	}

	// Obtener Primer dia de un periodo, actual o especifico
	public static function firstDayOf($period, DateTime $date = null){
	    $period = strtolower($period);
	    $validPeriods = array('year', 'quarter', 'month', 'week');
	 
	    if ( ! in_array($period, $validPeriods))
	        throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));
	 
	    $newDate = ($date === null) ? new DateTime() : clone $date;
	 
	    switch ($period) {
	        case 'year':
	            $newDate->modify('first day of january ' . $newDate->format('Y'));
	            break;
	        case 'quarter':
	            $month = $newDate->format('n') ;
	 
	            if ($month < 4) {
	                $newDate->modify('first day of january ' . $newDate->format('Y'));
	            } elseif ($month > 3 && $month < 7) {
	                $newDate->modify('first day of april ' . $newDate->format('Y'));
	            } elseif ($month > 6 && $month < 10) {
	                $newDate->modify('first day of july ' . $newDate->format('Y'));
	            } elseif ($month > 9) {
	                $newDate->modify('first day of october ' . $newDate->format('Y'));
	            }
	            break;
	        case 'month':
	            $newDate->modify('first day of this month');
	            break;
	        case 'week':
	            $newDate->modify(($newDate->format('w') === '0') ? 'monday last week' : 'monday this week');
	            break;
	    }

	    return $newDate;
	}

	// Obtener Ultimo dia de un periodo, actual o especifico
	public static function lastDayOf($period, DateTime $date = null){
	    $period = strtolower($period);
	    $validPeriods = array('year', 'quarter', 'month', 'week');
	 
	    if ( ! in_array($period, $validPeriods))
	        throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));
	 
	    $newDate = ($date === null) ? new DateTime() : clone $date;
	 
	    switch($period){
	        case 'year':
	            $newDate->modify('last day of december ' . $newDate->format('Y'));
	            break;
	        case 'quarter':
	            $month = $newDate->format('n') ;
	 
	            if ($month < 4) {
	                $newDate->modify('last day of march ' . $newDate->format('Y'));
	            } elseif ($month > 3 && $month < 7) {
	                $newDate->modify('last day of june ' . $newDate->format('Y'));
	            } elseif ($month > 6 && $month < 10) {
	                $newDate->modify('last day of september ' . $newDate->format('Y'));
	            } elseif ($month > 9) {
	                $newDate->modify('last day of december ' . $newDate->format('Y'));
	            }
	            break;
	        case 'month':
	            $newDate->modify('last day of this month');
	            break;
	        case 'week':
	            $newDate->modify(($newDate->format('w') === '0') ? 'now' : 'sunday this week');
	            break;
	    }
	 
	    return $newDate;
	}

	// Generar codigo de verificacion
	public static function rand($digits = 4){
		return rand(pow(10, $digits-1), pow(10, $digits)-1);
	}

	// Generar token de seguridad unico
	public static function token($identifiers = ''){
		return md5(uniqid($identifiers));
	}

	// Construir codigo unico
	public static function code($digits = 6){
		$code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $digits));
		return $code;
	}

	// Generar clave aleatoria
	public static function password($length = 8){
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%&*?';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

	// Saber si es un numero de telefono
	public static function isPhone($number){
		return is_numeric($number) && strlen($number) == 9;
	}

	// Saber si es un email
	public static function isEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	// Saber si es un dni
	public static function isDNI($dni){
		return is_numeric($dni) && strlen($dni) == 8;
	}

	/**
	 * Validar si una fecha es correcta o esta en formato correcto: 2017-12-24
	 * @param $str_date
	 * @return bool
	 */
	public static function isDate($str_date){
		$arr = explode('-', $str_date);
		if(count($arr) == 3){
			if(is_numeric($arr[0]) && $arr[0] > 1000){
				if(is_numeric($arr[1]) && $arr[1] > 0 && $arr[1] <= 12){
					if (is_numeric($arr[2]) && $arr[2] > 0 && $arr[2] <= 31){
						return true;
					}
				}
			}
		}
        return false;
	}

    public static function isDateTime($date_time_str){
        return (DateTime::createFromFormat('Y-m-d H:i', $date_time_str) !== false) ||
            (DateTime::createFromFormat('Y-m-d H:i:s', $date_time_str) !== false);
    }

    // Calcular distancia entre 2 puntos
    // $unit: "M" => miles, "K" => kilometers, "N" => nautical miles
    public static function getDistance($lat1, $lon1, $lat2, $lon2, $unit = 'K'){
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    /**
     * @param string $date
     * @return false|int|string
     */
    public static function getYears($date){
        $birthDate = explode("-", $date);
        if(is_array($birthDate) && count($birthDate) == 3){
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
                ? ((date("Y") - $birthDate[0]) - 1)
                : (date("Y") - $birthDate[0]));
        } else {
            $age = 0;
        }
        return $age;
    }

    /**
     * Obtener direccion mediante coordenadas
     * @param float $lat
     * @param float $lng
     * @return string
     */
	public static function getAddress($lat,$lng){
		$rsp = @file_get_contents('https://www.uber.com/api/address-lookup?lat='.$lat.'&lng='.$lng);
		if($rsp){
			$json = @json_decode($rsp);
			if($json && $json->longAddress){
				return $json->longAddress;
			}
		}
		return '';
	}

    /**
     * Obtener "hace x tiempo" mediante segundos
     * @param int $time
     * @return string
     */
	public static function within($time){
		$periods = array("seg", "min", "hora", "día", "sem.", "mes", "año", "dec.");
		$lengths = array("60","60","24","7","4.35","12","10");

		$difference = $time-time();
		$prefx = $difference<0?'Hace':'En';
		$difference = abs($difference);

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j] .= "s";
		}

		return $prefx.' '.$difference.' '.$periods[$j];
	}

    /**
     * Ordenar menu/categoria multinivel
     * @param $array
     * @param int $parent_id
     * @return array
     */
    public static function ordMenu($array, $parent_id = 0)
    {
        $temp_array = array();
        foreach ($array as $element) {
            if ($element->id_parent == $parent_id) {
                $element->children = Util::ordMenu($array, $element->id);
                $temp_array[] = $element;
            }
        }
        return $temp_array;
    }

    /**
     * Obtener el numero de semanas entre 2 fechas
     * @param $date1
     * @param $date2
     * @return float
     */
    public static function datediffInWeeks($date1, $date2){
        if($date1 > $date2) return Util::datediffInWeeks($date2, $date1);
        $first = DateTime::createFromFormat('Y-m-d', $date1);
        $second = DateTime::createFromFormat('Y-m-d', $date2);
        return floor($first->diff($second)->days/7);
    }


    public function __destruct()
    {
        exit('destructed');
    }
}
<?php namespace Inc;

use Models\User;

class Auth
{

    /* @var User */
    public static $user = null;

    /* @var bool */
    public static $is_api = true; // Determina si logeo por API
    /* @var bool */
    public static $is_ajax = false; // Determina si logeo por API

    /**
     * @param string $token
     * @return bool
     */
    public static function init($token = '')
    {
        // El metodo init solo se puede llamar una vez
        if (self::logged()) exit('Ya fue logeado antes: ' . self::id());

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            self::$is_ajax = true;
        }

        // Buscar en Parametros
        if (empty($token)) {
            $token = _REQ('token');
        }

        // Buscar en Headers
        if (empty($token)) {
            $token = self::getBearerToken();
        }

        // Buscar en Cookie
        if (empty($token)) {
            $token = @$_COOKIE[STG::get('session_key')];
            self::$is_api = false;
        }

        // Buscar en Session
        if (empty($token)) {
            $token = @$_SESSION[STG::get('session_key')];
            self::$is_api = false;
        }

        if (!empty($token)) {
            $user = User::where('token', '=', $token, true)
                ->select('users.*')
                ->first();

            if ($user && $user->exist()) {
                self::$user = $user;

                return true;
            }
        }

        return false;
    }

    /**
     * Get hearder Authorization
     * */
    static function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header
     * */
    static function getBearerToken()
    {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return '';
    }

    public static function isAPI()
    {
        return self::$is_api || self::$is_ajax;
    }


    public static function logged()
    {
        return self::user() && self::id() > 0;
    }

    public static function id()
    {
        return self::$user->id;
    }

    public static function id_branch()
    {
        return self::$user->id_branch;
    }

    public static function state()
    {
        return self::$user->state;
    }

    public static function enabled()
    {
        return self::state() == User::_STATE_ENABLED;
    }

    public static function root()
    {
        return self::logged() && self::user()->root();
    }

    public static function user()
    {
        return self::$user;
    }

}
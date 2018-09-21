<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Inc\STG;
use Inc\Util;
use Libs\Pixie\QB;
use Models\Log;
use Models\User;

class login extends _controller
{

    public function __construct()
    {
        parent::__construct(false);
    }

    public function index()
    {
        return view('login');
    }

    public function login(Req $req)
    {
        $username = $req->any('username');
        $password = $req->any('password');
        $remember = $req->any('remember') == 1;

        if (empty($username)) {
            return rsp('Ingresa un usuario')->set('field','username');

        } else if (empty($password)) {
            return rsp('Ingresa una contraseña')->set('field','password');

        } else {
            $username = addslashes($username);
            $password = md5(addslashes($password));

            if (Util::isEmail($username)) {
                $user = User::find('email', $username);
            } else {
                $user = User::find('username', $username);
            }

            if (!$user->exist()) {
                return rsp('Usuario / email incorrecto')->set('field','username');

            } else if ($user->password() != $password) {
                return rsp('Contraseña incorrecta')->set('field','password');

            } else {

                $user->data('date_login', QB::raw('NOW()'));

                if (empty($user->token)) {
                    $user->data('token', Util::token($user->id));
                }

                if ($user->update()) {

                    // Si quiere que recuerde la sesion, en cookie 10 años
                    if ($remember) {
                        setcookie(STG::get('session_key'), $user->token, time() + (10 * 365 * 24 * 60 * 60), '/');
                    } else {
                        setcookie(STG::get('session_key'), $user->token, 0, '/');
                    }

                    Log::add(Log::LOGIN, $user->id);

                    return rsp(true)->merge($user);

                } else {
                    return rsp('Error interno :: DB');
                }
            }

        }

    }

    public function logout()
    {
        if (Auth::init()) {
            Auth::user()
                ->data('date_logout', QB::raw('NOW()'))
                ->update();

            Log::add(Log::LOGOUT, Auth::id());
        }

        $_SESSION[STG::get('session_key')] = 0;
        unset($_SESSION[STG::get('session_key')]);
        session_destroy();
        setcookie(STG::get('session_key'), null, -1, '/');

        if (isset($_SERVER["HTTP_REFERER"])) {
            header('Location: ' . URL_BASE . 'login?r=' . base64_encode($_SERVER['HTTP_REFERER']));
        } else {
            header('Location: ' . URL_BASE . 'login');
        }
    }

}
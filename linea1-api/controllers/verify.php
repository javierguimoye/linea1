<?php namespace Controllers;

use Inc\Auth;
use Inc\DB;
use Inc\Perms;
use Inc\STG;
use Libs\Pixie\QB;
use Models\Station;
use Models\Type_notification;

class verify extends _controller
{

    public function index()
    {
        $user = DB::o("
            SELECT us.*,
                   mo.url mo_url
            FROM users us
              JOIN roles ro ON ro.id = us.id_role
                LEFT JOIN modules mo ON mo.id = ro.id_module
        ");

        return rsp(true)
            ->set('user', Auth::user())
            ->set('menu', Perms::menuSorted())
            ->set('stg', STG::all())
            ->set('type_notifications', Type_notification::all())
            ->set('stations', QB::query('SELECT id, name, district, address, lat, lng FROM stations')->get())
            ->set('messages', QB::query('SELECT m.id, m.parent_type, tn.notificacion, m.message, m.state, m.date_created 
                                                FROM messages m 
                                                INNER JOIN 
                                                type_notifications tn ON 
                                                m.parent_type = tn.id 
                                                WHERE m.state = "1" & tn.state= "1"')->get())
            ->set('home', $user->mo_url);
    }

}
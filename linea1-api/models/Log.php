<?php namespace Models;

class Log extends _model
{

    const LOGIN = 1; // :id_user inicio sesion
    const LOGOUT = 2; // :id_user cerro sesion
    const CREATE = 3; // :id_user creo :id_ref en tabla :target
    const UPDATE = 4; // :id_user actualizo :id_ref en tabla :target
    const DELETE = 5; // :id_user elimino :id_ref en tabla :target

    /* @var int */
    public $id;
    /* @var int */
    public $id_user;
    /* @var int */
    public $id_ref;
    /* @var int */
    public $type;
    /* @var string */
    public $target;
    /* @var string */
    public $date_created;

    public static function add($type, $id_user, $id_ref = 0, $target = '')
    {
        Log::insert([
            'type' => $type,
            'id_user' => $id_user,
            'id_ref' => $id_ref,
            'target' => $target
        ]);
    }

}
<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Models\Turn;

class turns extends _controller
{

    public function index()
    {
        $roles = Turn::all();

        if (Auth::isAPI()) {
            return $roles;
        }

        return view('turns')->set('items', $roles);
    }

    public function create(Req $req)
    {
        $item = Turn::find($req->num('id'));
        $item->data('name', $req->any('name'));
        $item->data('time_from', $req->any('time_from'));
        $item->data('time_to', $req->any('time_to'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else if (empty($item->time_from)) {
            return rsp('Especifica la hora de apertura');

        } else if (empty($item->time_to)) {
            return rsp('Especifica la hora de cierre');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Turn::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Turn::deleteRSP($req->num('id'));
    }

}
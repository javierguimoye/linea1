<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Models\Printer;

class printers extends _controller
{

    public function index()
    {
        $items = Printer::where('id_branch', Auth::id_branch())->get();

        if (Auth::isAPI()) {
            return $items;
        }

        return view('printers')->set('items', $items);
    }

    public function create(Req $req)
    {
        $item = Printer::find($req->num('id'));
        $item->data('id_branch', Auth::id_branch());
        $item->data('id_user', Auth::id());
        $item->data('name', $req->any('name'));
        $item->data('ip', $req->any('ip'));
        $item->data('serial', $req->any('serial'));
        $item->data('authorization', $req->any('authorization'));
        $item->data('num_letters', $req->num('num_letters'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else if (empty($item->ip)) {
            return rsp('Ingresa la dirección IP');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Printer::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Printer::deleteRSP($req->num('id'));
    }

}
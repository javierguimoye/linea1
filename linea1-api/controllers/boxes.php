<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Models\Box;
use Models\Printer;

class boxes extends _controller
{

    public function index()
    {
        $items = Box::where('boxes.id_branch', Auth::id_branch())
            ->select('boxes.*', 'pr.name pr_name')
            ->leftJoin('printers pr', 'pr.id', '=', 'boxes.id_printer')
            ->get();

        //exit($items->getQuery()->getRawSql());


        if (Auth::isAPI()) {
            return $items;
        }

        return view('boxes')->set('items', $items);
    }

    public function create(Req $req)
    {
        $item = Box::find($req->num('id'));
        $item->data('id_user', Auth::id());
        $item->data('id_branch', Auth::id_branch());
        $item->data('name', $req->any('name'));
        $item->data('id_printer', $req->num('id_printer'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Box::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Box::deleteRSP($req->num('id'));
    }

    /**
     * Obtener datos necesarios para el formulario
     * @return \Inc\Rsp
     */
    public function dataForm()
    {
        return rsp(true)
            ->set('printers', Printer::where('id_branch', Auth::id_branch())->orderBy('name')->get());
    }

}
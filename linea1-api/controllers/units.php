<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Models\Unit;

class units extends _controller
{

    public function index()
    {
        $items = Unit::QBuilder()
            ->select('units.*', 'un2.name un2_name')
            ->leftJoin('units un2', 'un2.id', '=', 'units.id_unit')
            ->where('units.state', Unit::_STATE_ENABLED)
            ->orderBy('units.id_unit,units.name')
            ->get();

        if (Auth::isAPI()) {
            return $items;
        }

        return view()->set('items', $items);
    }

    public function create(Req $req)
    {
        $item = Unit::find($req->num('id'));
        $item->data('id_user', Auth::id());
        $item->data('name', $req->any('name'));
        $item->data('code', $req->any('code'));
        $item->data('id_unit', $req->num('id_unit'));
        $item->data('operator', $req->any('operator'));
        $item->data('value', $req->any('value'));

        if ($item->id_unit <= 0) {
            $item->data('value', 1);
        }

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else if (empty($item->code)) {
            return rsp('Ingresa un código');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Unit::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Unit::deleteRSP($req->num('id'));
    }

    /**
     * Obtener datos necesarios para el formulario
     * @return \Inc\Rsp
     */
    public function dataForm()
    {
        return rsp(true)
            ->set('units', Unit::all());
    }

}
<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Inc\Util;
use Models\Type;

class type_conforts extends types
{

    public function index()
    {
        $items = Type::where('type', Type::CONFORT)->get();

        if (Auth::isAPI()) {
            return $items;
        }
        return view('types')->set('opts', [
            'type' => Type::CONFORT,
            'endpoint' => self::$module,
            'title' => 'Comodidad',
            'title_code' => 'Descripción'
        ])->set('items', $items)
            ->set('items_order', Util::ordMenu($items));
    }

    public function create(Req $req)
    {
        $item = Type::find($req->num('id'));
        $item->data('type', Type::CONFORT);
        $item->data('name', $req->any('name'));
        $item->data('code', $req->any('code'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

}
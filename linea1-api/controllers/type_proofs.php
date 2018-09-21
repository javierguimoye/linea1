<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Inc\Util;
use Models\Type;

class type_proofs extends types
{

    public function index()
    {
        $items = Type::where('type', Type::PROOF)->get();

        if (Auth::isAPI()) {
            return $items;
        }
        return view('types')->set('opts', [
            'type' => Type::PROOF,
            'endpoint' => self::$module,
            'title' => 'Tipo de comprobante',
            'title_code' => 'Código'
        ])->set('items', $items)
            ->set('items_order', Util::ordMenu($items));
    }

    public function create(Req $req)
    {
        $item = Type::find($req->num('id'));
        $item->data('type', Type::PROOF);
        $item->data('name', $req->any('name'));
        $item->data('code', $req->any('code'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

}
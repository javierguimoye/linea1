<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Inc\Util;
use Models\Type;

class type_brands extends types
{

    public function index()
    {
        $items = Type::where('type', Type::BRAND)->get();

        if (Auth::isAPI()) {
            return $items;
        }
        return view('types')
            ->set('opts', [
                'type' => Type::BRAND,
                'endpoint' => self::$module,
                'maxDepth' => 1,
                'title' => 'Marca',
                'title_code' => 'Código',
                'title_color' => 'Color'
            ])
            ->set('items', $items)
            ->set('items_order', Util::ordMenu($items));
    }

    public function create(Req $req)
    {
        $item = Type::find($req->num('id'));
        $item->data('type', Type::BRAND);
        $item->data('name', $req->any('name'));
        $item->data('code', $req->any('code'));
        $item->data('color', $req->any('color'));
        $item->data('favorite', $req->num('favorite'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

}
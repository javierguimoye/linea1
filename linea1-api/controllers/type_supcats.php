<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Inc\Util;
use Models\Type;

class type_supcats extends types
{

    public function index()
    {
        $items = Type::where('type', Type::SUPCAT)->get();

        if (Auth::isAPI()) {
            return $items;
        }
        return view('types')
            ->set('opts', [
                'type' => Type::SUPCAT,
                'endpoint' => self::$module,
                'maxDepth' => 2,
                'title' => 'Categoría',
                'title_code' => false,
                'title_color' => 'Color',
                'title_favorite' => 'Favorito'
            ])
            ->set('items', $items)
            ->set('items_order', Util::ordMenu($items));
    }

    public function create(Req $req)
    {
        $item = Type::find($req->num('id'));
        $item->data('type', Type::SUPCAT);
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
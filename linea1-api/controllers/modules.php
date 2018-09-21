<?php namespace Controllers;

use Inc\Req;
use Inc\Util;
use Models\Module;

class modules extends _controller
{

    public function index()
    {
        $menu_all = Module::where('state', 1)->orderBy('sort')->get();

        $items = [];

        foreach ($menu_all as $item) {
            $items[$item->id] = $item;
        }

        return rsp(true)
            ->set('menu_all', Util::ordMenu($menu_all))
            ->set('items', $items);
    }

    public function create(Req $req)
    {
        $item = Module::find($req->num('id'));
        $item->data('name', $req->any('name'));
        if (!$item->exist() || $item->root == 0) {
            $item->data('url', $req->any('url'));
        }
        $item->data('icon', $req->any('icon'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function remove(Req $req)
    {
        $item = Module::find($req->num('id'));
        if ($item->root == 1) {
            return rsp('is_root');
        } else {
            return Module::deleteRSP($req->num('id'), true);
        }
    }

    public function dataForm(Req $req)
    {
        return rsp(true)
            ->set('item', Module::find($req->num('id')));
    }

    public function resort(Req $req)
    {
        $this->_save_list_resort($req->arr('items'));
        return rsp(true);
    }

    private function _save_list_resort($list, $id_parent = 0, &$sort = 0, $level = 0)
    {
        foreach ($list as $item) {
            $sort++;

            Module::where($item->id)->update([
                'id_parent' => $id_parent,
                'sort' => $sort,
                'level' => $level
            ]);

            if (isset($item->children)) {
                $this->_save_list_resort($item->children, $item->id, $sort, $level + 1);
            }
        }
    }

}
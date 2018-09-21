<?php namespace Controllers;

use Inc\Req;
use Models\Type;

abstract class types extends _controller
{

    public function index()
    {
        return Type::all();
    }

    public function type($type)
    {
        return Type::where('type', $type)
            ->where(Type::STATE, Type::_STATE_ENABLED)
            ->get();
    }

    public function create(Req $req)
    {
        $item = Type::find($req->num('id'));
        $item->data('type', $req->num('type'));
        $item->data('name', $req->any('name'));
        $item->data('code', $req->any('code'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Type::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Type::deleteRSP($req->num('id'));
    }

    public function reorder(Req $req)
    {
        $this->_save_list($req->arr('list'));
        return rsp(true);
    }

    private function _save_list($list, $id_parent = 0, &$sort = 0, $level = 0)
    {
        foreach ($list as $item) {
            $sort++;

            Type::where($item['id'])->update([
                'id_parent' => $id_parent,
                'sort' => $sort,
                'level' => $level
            ]);

            if (array_key_exists('children', $item)) {
                $this->_save_list($item['children'], $item['id'], $sort, $level + 1);
            }
        }
    }

}
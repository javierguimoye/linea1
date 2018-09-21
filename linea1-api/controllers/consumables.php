<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Country;
use Models\Type;
use Models\Consumable;

class consumables extends _controller
{

    public function index(Req $req)
    {
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'name'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('word', $req->any('word'));

        $qb = Consumable::where('state', '!=', Consumable::_STATE_DELETED);

        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('name', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);

        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items', $qb->get());

        return $fils;
    }

    public function create(Req $req)
    {
        $item = Consumable::find($req->num('id'));
        $item->data('name', $req->any('name'));
        $item->data('stock', $req->num('stock'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Consumable::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm(Req $req)
    {
        return rsp(true)
            ->set('item', Consumable::find($req->num('id')));
    }

    public function remove(Req $req)
    {
        return Consumable::deleteRSP($req->num('id'));
    }

}
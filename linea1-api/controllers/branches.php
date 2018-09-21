<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Branch;

class branches extends _controller
{

    public function index(Req $req)
    {
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'name'))
            ->set('word', $req->any('word'));

        $qb = QB::table('branches');
        $qb->where('branches.state', '!=', Branch::_STATE_DELETED);

        if (!empty($fils->word))
            $qb->where('branches.name', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);

        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items', $qb->get());

        if (Auth::isAPI()) {
            return $fils;
        }

        return view('branches')->set('fils', $fils);
    }

    public function all()
    {
        return rsp(true)->set('items', Branch::all());
    }

    public function create(Req $req)
    {
        $item = Branch::find($req->num('id'));
        $item->data('id_user', Auth::id());
        $item->data('name', $req->any('name'));
        $item->data('phone', $req->any('phone'));
        $item->data('address', $req->any('address'));
        $item->data('lat', $req->num('lat'));
        $item->data('lng', $req->num('lng'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Branch::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function edit($id)
    {
        $item = Branch::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Branch::deleteRSP($req->num('id'));
    }

}
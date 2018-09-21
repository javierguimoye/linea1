<?php namespace Controllers;

use Inc\Auth;
use Inc\Perms;
use Inc\Req;
use Inc\Util;
use Libs\Pixie\QB;
use Models\Provider;

class providers extends _controller
{

    public function index(Req $req)
    {
        $fils = new \stdClass();
        $fils->max = $req->num('max', 10);
        $fils->page = $req->num('page', 1);
        $fils->sort = $req->any('sort', 'asc');
        $fils->sort_by = $req->any('sort_by', 'name');
        $fils->word = $req->any('word');
        $fils->id_role = $req->num('id_role');
        $fils->state = $req->num('state');
        $fils->offset = ($fils->page - 1) * $fils->max;

        $qb = Provider::where('state', '!=', Provider::_STATE_DELETED);

        if (!empty($fils->word))
            $qb->where("CONCAT(name,document,email,contact)", 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

        $qb->offset($fils->offset);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);

        $fils->total = $qb->count();
        $fils->pages = ceil($fils->total / $fils->max);

        $fils->items = $qb->get();

        if (Auth::isAPI()) {
            return $fils;
        }

        return view()->set('fils', $fils);
    }

    public function item($id)
    {
        $item = Provider::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function create(Req $req)
    {
        $item = Provider::find($req->num('id'));

        $item->data('id_user', Auth::id());
        $item->data('name', $req->any('name'));
        $item->data('document', $req->any('document'));
        $item->data('contact', $req->any('contact'));
        $item->data('phone', $req->any('phone'));
        $item->data('email', $req->any('email'));
        $item->data('address', $req->any('address'));
        $item->data('notes', $req->any('notes'));

        if (empty($item->name)) {
            return rsp('Ingresa el nombre');

        } elseif (empty($item->document)) {
            return rsp('Ingresa el RUC');

        } else if (!empty($item->email) && !Util::isEmail($item->email)) {
            return rsp('Email incorrecto');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function remove(Req $req)
    {
        return Provider::deleteRSP($req->num('id'));
    }

}
<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Management;
use Models\Role;
use Models\User;

class users extends _controller
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

        $qb = QB::table('users');
        $qb->join('roles', 'roles.id', '=', 'users.id_role');
        $qb->select('users.*', 'roles.name ro_name');
        $qb->where('users.state', '!=', User::_STATE_DELETED);

        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('users.name', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

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
        $item = User::find($req->num('id'));
        $item->data('id_role', $req->num('id_role'));
      //  $item->data('id_management', $req->num('id_management'));
        $item->data('id_user', Auth::id());
        $item->data('name', $req->any('name'));
        $item->data('surname', $req->any('surname'));
        $item->data('username', $req->any('username'));

        if (!empty($req->any('password'))) {
            $item->data('password', md5($req->any('password')));
        }

        if (empty($item->id_role)) {
            return rsp('Elige un perfil');

        } else if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else if (empty($item->username)) {
            return rsp('Ingresa un usuario');

        } else if (User::where('username', $item->username)->where('id', '!=', $item->id)->first()) {
            return rsp('Usuario ya registrado');

        } else if (!$item->exist() && empty($item->password())) {
            return rsp('Ingresa una contraseña');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = User::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function edit($id)
    {
        $item = User::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm(Req $req)
    {
        return rsp(true)
            ->set('item', $req->num('id') > 0 ? User::find($req->num('id')) : null)
            ->set('roles', Role::all());
          //  ->set('managements', Management::all());
    }

    public function remove(Req $req)
    {
        return User::deleteRSP($req->num('id'));
    }

}
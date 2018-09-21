<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Client;
use Models\Country;
use Models\Type;

class clients extends _controller
{

    //get all clients
    public function index(Req $req){
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'nombre'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('word', $req->any('word'))
            ->set('id_type_client', $req->num('id_type_client'));

        $qb = QB::table('clients');
        $qb->where('clients.state', '!=', Client::_STATE_DELETED);

        //exit(QB::raw('DATE(date_created)'));


        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('clients.nombre', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

  //      if ($fils->id_type_client > 0)
//            $qb->where('clients.id_type_client', '=', $fils->id_type_client);

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);
        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items', $qb->get());


        if (Auth::isAPI()) {
            return $fils;
        }

        return view('clients')
            ->set('type_clients', Type::where('type', Type::CLIENT)->get())
            ->set('fils', $fils);
    }

    //create clients
    public function create(Req $req)
    {
        $item = Client::find($req->num('id'));
        $item->data('id_user', $req->num('id_user'));
        $item->data('nombre', $req->any('nombre'));
        $item->data('descripcion', $req->any('descripcion'));
        $item->data('ruc', $req->num('ruc'));
        $item->data('ubicacion', $req->any('ubicacion'));
        $item->data('latitud', $req->any('latitud'));
        $item->data('longitud', $req->any('longitud'));

        if (empty($item->nombre)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    //get clients by id
    public function item($id)
    {
        $item = Client::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    //edit client
    public function edit($id)
    {
        $item = Client::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    /**
     * Obtener datos necesarios para el formulario
     * @param $id
     * @return \Inc\Rsp
     */
    public function dataForm($id = 0)
    {
        $id = _REQ_INT('id');
        return rsp(true)
            ->set('item', $id > 0 ? Client::find($id) : null);
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
           // ->set('type_documents', Type::where('type', Type::DOCUMENT)->get())
           // ->set('countries', Country::all());
    }

    public function remove(Req $req)
    {
        return Client::deleteRSP($req->num('id'));
    }

}
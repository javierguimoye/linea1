<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Country;
use Models\Tipo_movilidad;
use Models\Unidade;
use Models\Type;

class unidades extends _controller
{

    //get all unidades
    public function index(Req $req){
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'date_created'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('word', $req->any('word'));
        //    ->set('id_type_client', $req->num('id_type_client'));

        $qb = QB::table('unidades');
        $qb->where('unidades.state', '!=', Unidade::_STATE_DELETED);

        //exit(QB::raw('DATE(date_created)'));


        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('unidades.tracto_unidad', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

  //      if ($fils->id_type_client > 0)
//            $qb->where('clients.id_type_client', '=', $fils->id_type_client);

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);
        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items',  QB::query('SELECT u.id, u.id_tipo_movilidad, tm.nombre as nombre_movilidad, u.tracto_unidad, u.botella, 
                                            u.state, u.date_created, u.date_updated, u.date_deleted, tm.nombre 
                                            FROM unidades u 
                                            INNER JOIN tipo_movilidads tm 
                                            on u.id_tipo_movilidad = tm.id 
                                            where tm.state="1" and u.state = "1"')->get());

        if (Auth::isAPI()) {
            return $fils;
        }

        return view('unidades')
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
            ->set('fils', $fils);
    }

    //create unidades
    public function create(Req $req)
    {
        $item = Unidade::find($req->num('id'));
        $item->data('id_tipo_movilidad', $req->num('id_tipo_movilidad'));
        $item->data('tracto_unidad', $req->any('tracto_unidad'));
        $item->data('botella', $req->any('botella'));

        if (empty($item->tracto_unidad)) {
            return rsp('Ingresa una Unidad');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    //get unidades by id
    public function item($id)
    {
        $item = Unidade::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    //edit unidades
    public function edit($id)
    {
        $item = Unidade::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm($id = 0)
    {
        $id = _REQ_INT('id');
        return rsp(true)
            ->set('item', $id > 0 ? Unidade::find($id) : null)
            ->set('tipo_movilidad', Tipo_movilidad::all());
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
           // ->set('type_documents', Type::where('type', Type::DOCUMENT)->get())
           // ->set('countries', Country::all());
    }

    public function remove(Req $req)
    {
        return Unidade::deleteRSP($req->num('id'));
    }

}
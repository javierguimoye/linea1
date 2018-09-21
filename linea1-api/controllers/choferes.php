<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Country;
use Models\Chofere;
use Models\Type;
use Models\Tipo_unidad;
use Models\Unidade;

class choferes extends _controller
{

    //get all choferes
    public function index(Req $req){
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'nombre'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('word', $req->any('word'));
        //    ->set('id_type_client', $req->num('id_type_client'));

        $qb = QB::table('choferes');
        $qb->where('choferes.state', '!=', Chofere::_STATE_DELETED);

        //exit(QB::raw('DATE(date_created)'));


        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('choferes.nombre', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

  //      if ($fils->id_type_client > 0)
//            $qb->where('clients.id_type_client', '=', $fils->id_type_client);

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);
        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items',  QB::query('SELECT ch.id, ch.id_unidad, tu.placa, ch.nombre, ch.apellido, ch.dni, 
                                            ch.state, ch.date_created, ch.date_updated, ch.date_deleted 
                                            FROM choferes ch 
                                            INNER JOIN unidades tu 
                                            on ch.id_unidad = tu.id 
                                            where tu.state="1" and ch.state = "1"')->get());

        if (Auth::isAPI()) {
            return $fils;
        }

        return view('choferes')
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
            ->set('fils', $fils);
    }

    //create choferes
    public function create(Req $req)
    {
        $item = Chofere::find($req->num('id'));
        $item->data('id_unidad', $req->num('id_unidad'));
        $item->data('nombre', $req->any('nombre'));
        $item->data('apellido', $req->any('apellido'));
        $item->data('dni', $req->num('dni'));

        if (empty($item->nombre)) {
            return rsp('Ingresa un Nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    //get choferes by id
    public function item($id)
    {
        $item = Chofere::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    //edit choferes
    public function edit($id)
    {
        $item = Chofere::find($id);

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
            //->set('item', $id > 0 ? Chofere::find($id) : null)
         ->set('item', $id > 0 ? QB::query('SELECT ch.id, ch.id_unidad, tu.placa, ch.nombre, ch.apellido,
                                                  ch.dni, ch.state, ch.date_created, ch.date_updated, ch.date_deleted
                                                  FROM choferes ch INNER JOIN unidades tu on
                                                  ch.id_unidad = tu.id where tu.state="1" and
                                                  ch.state = "1" and ch.id = '.$id.' ')->first() : null)

            ->set('unidades', Unidade::all());
        // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
        // ->set('type_documents', Type::where('type', Type::DOCUMENT)->get())
        // ->set('countries', Country::all());
    }


    public function remove(Req $req)
    {
        return Chofere::deleteRSP($req->num('id'));
    }

}
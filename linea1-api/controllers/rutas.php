<?php namespace Controllers;

use Inc\Auth;
use Inc\DB;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Chofere;
use Models\Client;
use Models\Country;
use Models\Ruta;
use Models\Ruta_cliente;
use Models\Tipo_unidad;
use Models\Type;

class rutas extends _controller
{

    //get all rutas
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

        $qb = QB::table('rutas');
        $qb->where('rutas.state', '!=', Ruta::_STATE_DELETED);

        //exit(QB::raw('DATE(date_created)'));


        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('rutas.nombre', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

  //      if ($fils->id_type_client > 0)
//            $qb->where('clients.id_type_client', '=', $fils->id_type_client);

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);
        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items',  QB::query('SELECT r.id, r.id_tipo_unidad, r.nombre, tu.nombre as nombre_unidad, r.distancia, r.viatico, r.movilidad, 
                                            r.hotel, r.cochera, r.total_dia, r.state, r.date_created, r.date_updated, r.date_deleted 
                                            FROM rutas r 
                                            INNER JOIN tipo_unidads tu 
                                            on r.id_tipo_unidad = tu.id 
                                            where tu.state="1" and r.state = "1"')->get());

        if (Auth::isAPI()) {
            return $fils;
        }

        return view('rutas')
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
            ->set('fils', $fils);
    }

    //create rutas
    public function create(Req $req){

        $item = Ruta::find($req->num('id'));
        $item->data('id_tipo_unidad', $req->num('id_tipo_unidad'));
        $item->data('id_chofer', $req->num('id_chofer'));
        $item->data('nombre', $req->any('nombre'));
        $item->data('distancia', $req->any('distancia'));
        $item->data('viatico', $req->num('viatico'));
        $item->data('movilidad', $req->num('movilidad'));
        $item->data('hotel', $req->num('hotel'));
        $item->data('cochera', $req->num('cochera'));
        $item->data('total_dia', $req->any('total_dia'));

        $ids_clients = $req->arr('ids_clients');

        if (empty($item->nombre)) {
            return rsp('Ingresa un nombre');
        } else {
            $r = $item->createOrUpdateRSP();

            if ($r->ok) {

                DB::table('ruta_clientes')->where('id_ruta', '=', $r->id)->delete();

                foreach ($ids_clients as $id_cliente) {
                    DB::table('ruta_clientes')->insert([
                        'id_ruta' => $r->id,
                        'id_cliente' => $id_cliente
                    ]);
                }

            }

            return $r;
        }
    }

    //get rutas by id
    public function item($id)
    {
        $item = Ruta::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    //edit rutas
    public function edit($id)
    {
        $item = Ruta::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm($id = 0,$id_ruta=0)
    {
        $id         = _REQ_INT('id');
        $id_ruta    = _REQ_INT('id_ruta');

        $item = $id > 0 ? Ruta::find($id) : null;

        if($item!=null){
            if ($item->exist() ) {
                $item->clientes = QB::table('ruta_clientes rt')
                    ->join('rutas r', 'rt.id_ruta', '=', 'r.id')
                    ->join('clients c', 'rt.id_cliente', '=', 'c.id')
                    ->select('rt.id_ruta', 'rt.id_cliente','c.nombre')
                     ->where('r.id', '=', $item->id)
                    ->get();
            }
        }else {
            $item = null;
        }

        return rsp(true)
            ->set('item', $item)
            ->set('tipo_unidad', Tipo_unidad::all())
            ->set('choferes', Chofere::all())
            ->set('clientes', Client::all());
    }

    public function remove(Req $req)
    {
        return Ruta::deleteRSP($req->num('id'));
    }

}
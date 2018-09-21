<?php namespace Controllers;

use Inc\Auth;
use Inc\DB;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Country;
use Models\Proveedore;
use Models\Tipo_gasto;
use Models\Type;

class proveedores extends _controller
{

    //get all proveedores
    public function index(Req $req){
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'proveedor'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('word', $req->any('word'));
        //    ->set('id_type_client', $req->num('id_type_client'));

        $qb = QB::table('proveedores');
        $qb->where('proveedores.state', '!=', Proveedore::_STATE_DELETED);

        //exit(QB::raw('DATE(date_created)'));


        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('proveedores.proveedor', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

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

        return view('proveedores')
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
            ->set('fils', $fils);
    }

    //create proveedores
    public function create(Req $req)
    {
        $item = Proveedore::find($req->num('id'));
        $item->data('proveedor', $req->any('proveedor'));
        $item->data('ruc', $req->num('ruc'));
        $item->data('concepto', $req->any('concepto'));

        $ids_tipos = $req->arr('ids_tipos');
/*
        if (empty($item->proveedor)) {

        } else {
            return $item->createOrUpdateRSP();
        }
        */

        if (empty($item->proveedor)) {
            return rsp('Ingresa un Proveedor');
        } else {
            $r = $item->createOrUpdateRSP();

            if ($r->ok) {


                DB::table('prov_tipogastos')->where('id_proveedor', '=', $r->id)->delete();

                foreach ($ids_tipos as $id_tipo_gasto) {
                    DB::table('prov_tipogastos')->insert([
                        'id_proveedor' => $r->id,
                        'id_tipo_gasto' => $id_tipo_gasto
                    ]);
                }

            }

            return $r;
        }

    }

    //get proveedores by id
    public function item($id)
    {
        $item = Proveedore::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    //edit Proveedore
    public function edit($id)
    {
        $item = Proveedore::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm($id = 0,$id_gasto=0)
    {
        $id         = _REQ_INT('id');
        $id_gasto   = _REQ_INT('id_gasto');

        $item = $id > 0 ? Proveedore::find($id) : null;

        if($item!=null){
            if ($item->exist() ) {
                $item->tipo_gastos = QB::table('prov_tipogastos ptg')
                    ->join('proveedores p', 'ptg.id_proveedor', '=', 'p.id')
                    ->join('tipo_gastos t', 'ptg.id_tipo_gasto', '=', 't.id')
                    ->select('ptg.id_proveedor', 'ptg.id_tipo_gasto','t.nombre')
                    ->where('p.id', '=', $item->id)
                    ->get();
            }
        }else {
            $item = null;
        }

        return rsp(true)
            ->set('item', $item)
            ->set('tipo_gastos', Tipo_gasto::all());

    }

    public function remove(Req $req)
    {
        return Proveedore::deleteRSP($req->num('id'));
    }

}
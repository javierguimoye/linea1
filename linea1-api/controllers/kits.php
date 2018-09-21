<?php namespace Controllers;

use Inc\DB;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Compekit;
use Models\Kit;

class kits extends _controller
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

        $qb = Kit::where('state', '!=', Kit::_STATE_DELETED);

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
        $item = Kit::find($req->num('id'));
        $item->data('serie', $req->any('serie'));
        $item->data('name', $req->any('name'));
        $item->data('date_reviewed', $req->date('date_reviewed'));

        $ids_compekits = $req->arr('ids_compekits');

        $items = $req->arr('items');

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            $r = $item->createOrUpdateRSP();
            if ($r->ok) {
                DB::table('kit_compekits')->where('id_kit', '=', $r->id)->delete();
                foreach ($ids_compekits as $id) {
                    DB::table('kit_compekits')->insert([
                        'id_kit' => $r->id,
                        'id_compekit' => $id
                    ]);
                }

                foreach ($items as $o) {
                    $data = [];
                    $data['id_kit'] = $r->id;
                    $data['name'] = @$o->name ?: '';
                    $data['quantity'] = @$o->quantity ?: 0;
                    $data['brand'] = @$o->brand ?: '';
                    $data['model'] = @$o->model ?: '';
                    $data['serie'] = @$o->serie ?: '';

                    if (@$o->id > 0) {
                        DB::table('kit_items')->where('id', '=', $o->id)->update($data);
                    } else {
                        DB::table('kit_items')->insert($data);
                    }
                }

            }
            return $r;
        }
    }

    public function dataForm(Req $req)
    {

        $item = Kit::find($req->num('id'));

        if ($item->exist()) {
            $item->compekits = QB::table('kit_compekits pe')
                ->join('compekits co', 'co.id', '=', 'pe.id_compekit')
                ->select('co.id', 'co.name')
                ->where('pe.id_kit', '=', $item->id)
                ->get();

            $item->items = QB::table('kit_items')->where('id_kit', '=', $item->id)->get();

        } else {
            $item = null;
        }

        return rsp(true)
            ->set('item', $item)
            ->set('compekits', Compekit::all());
    }

    public function removeItem(Req $req)
    {
        $id = $req->num('id');
        if ($id <= 0) {
            return rsp(':id');
        } else if (QB::table('kit_items')->where($id)->delete()) {
            return rsp(true);
        } else {
            return rsp('error_db');
        }
    }

    public function remove(Req $req)
    {
        return Kit::deleteRSP($req->num('id'));
    }

}
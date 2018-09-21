<?php namespace Controllers;

use Inc\DB;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Competence;
use Models\Personal;

class personals extends _controller
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

        $qb = Personal::where('state', '!=', Personal::_STATE_DELETED);

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
        $item = Personal::find($req->num('id'));
        $item->data('name', $req->any('name'));
        $item->data('surname', $req->any('surname'));
        $item->data('document', $req->any('document'));

        $ids_competences = $req->arr('ids_competences');

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            $r = $item->createOrUpdateRSP();
            if ($r->ok) {
                DB::table('personal_competences')->where('id_personal', '=', $r->id)->delete();
                foreach ($ids_competences as $id) {
                    DB::table('personal_competences')->insert([
                        'id_personal' => $r->id,
                        'id_competence' => $id
                    ]);
                }
            }
            return $r;
        }
    }

    public function dataForm(Req $req)
    {

        $item = Personal::find($req->num('id'));

        if ($item->exist()) {
            $item->competences = QB::table('personal_competences pe')
                ->join('competences co', 'co.id', '=', 'pe.id_competence')
                ->select('co.id', 'co.name')
                ->where('pe.id_personal', '=', $item->id)
                ->get();

        } else {
            $item = null;
        }

        return rsp(true)
            ->set('item', $item)
            ->set('competences', Competence::all());
    }

    public function remove(Req $req)
    {
        return Personal::deleteRSP($req->num('id'));
    }

}
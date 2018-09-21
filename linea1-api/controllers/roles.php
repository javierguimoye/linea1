<?php namespace Controllers;

use Inc\DB;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Role;

class roles extends _controller
{

    public function index()
    {
        $qb = Role::where('state', '!=', Role::_STATE_DELETED);
        $qb->orderBy('name', 'ASC');

        return rsp(true)
            ->set('items', $qb->get());
    }

    public function create(Req $req)
    {
        $item = Role::find($req->num('id'));
        $item->data('id_module', $req->num('id_module'));
        $item->data('name', $req->any('name'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            $r = $item->createOrUpdateRSP();

            if ($r->ok) {

                DB::query("DELETE FROM perms WHERE id_role = $r->id");
                foreach ($req->arr('perms') as $o) {
                    DB::insert('perms', [
                        'id_role' => $r->id,
                        'id_module' => $o->id_module,
                        'see' => $o->see,
                        'edit' => $o->edit,
                        'shortcut' => $o->shortcut,
                    ]);
                }
            }

            return $r;
        }
    }

    public function dataForm(Req $req)
    {
        $id = $req->num('id');

        $modules = QB::query("
            SELECT mo.*,
                   pe.see,
                   pe.edit,
                   pe.shortcut
            FROM modules mo
              LEFT JOIN perms pe ON pe.id_module = mo.id AND pe.id_role = $id
            ORDER BY mo.sort
        ")->get();

        foreach ($modules as &$o) {
            $o->see = ($o->see == '1');
            $o->edit = ($o->edit == '1');
            $o->shortcut = ($o->shortcut == '1');
        }

        return rsp(true)
            ->set('item', $id > 0 ? Role::find($id) : null)
            ->set('modules', $modules);
    }

    public function remove(Req $req)
    {
        return Role::deleteRSP($req->num('id'));
    }

}
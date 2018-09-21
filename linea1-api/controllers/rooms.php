<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Models\Room;
use Models\RoomType;

class rooms extends _controller
{

    public function index()
    {
        $items = Room::where('id_branch', Auth::id_branch())->get();

        if (Auth::isAPI()) {
            return $items;
        }
        return view('rooms')->set('items', $items);
    }

    public function type($type)
    {
        return Room::where('type', $type)
            ->where(Room::STATE, Room::_STATE_ENABLED)
            ->get();
    }

    public function create(Req $req)
    {
        $item = Room::find($req->num('id'));
        $item->data('id_user', Auth::id());
        $item->data('id_branch', Auth::id_branch());
        $item->data('id_room_type', $req->num('id_room_type'));
        $item->data('name', $req->any('name'));
        $item->data('sell_online', $req->num('sell_online'));

        if ($item->id_room_type <= 0) {
            return rsp('Elige el tipo de habitación');
        } else if (empty($item->name)) {
            return rsp('Ingresa un nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Room::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Room::deleteRSP($req->num('id'));
    }

    public function reorder(Req $req)
    {
        $list = $req->arr('list');

        $sort = 0;
        foreach ($list as $item) {
            $sort++;

            Room::find($item['id'])->update([
                'sort' => $sort
            ]);
        }

        return rsp(true);
    }

    public function dataForm()
    {
        return rsp(true)
            ->set('room_types', RoomType::all());
    }

}
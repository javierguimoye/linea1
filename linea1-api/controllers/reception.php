<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Models\Room;
use Models\RoomType;
use Models\Turn;
use Models\Type;

class reception extends _controller
{

    public function index()
    {
        $room_types = RoomType::all();

        $rooms = Room::where('id_branch', Auth::id_branch())->get();

        foreach ($room_types as $rt) {
            $rt->rooms = Room::where('id_branch', Auth::id_branch())
                ->where('id_room_type', $rt->id)
                ->get();
        }

        if (Auth::isAPI()) {
            return $rooms;
        }

        return view('reception')
            ->set('room_types', $room_types)
            ->set('rooms', $rooms)
            ->set('methods', Type::where('type', Type::METHOD)->get())
            ->set('proofs', Type::where('type', Type::PROOF)->get());
    }


    public function getReservations()
    {
        return rsp(true)
            ->set('rooms', Room::where('id_branch', Auth::id_branch())->get());
    }


    public function create(Req $req)
    {
        $item = Turn::find($req->num('id'));
        $item->data('name', $req->any('name'));
        $item->data('time_from', $req->any('time_from'));
        $item->data('time_to', $req->any('time_to'));

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else if (empty($item->time_from)) {
            return rsp('Especifica la hora de apertura');

        } else if (empty($item->time_to)) {
            return rsp('Especifica la hora de cierre');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Turn::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Turn::deleteRSP($req->num('id'));
    }

}
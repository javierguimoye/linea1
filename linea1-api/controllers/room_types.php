<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\RoomType;
use Models\Type;

class room_types extends _controller
{

    public function index()
    {
        $items = RoomType::QBuilder()
            ->select('room_types.*', "GROUP_CONCAT(tc.id_type_confort separator ',') id_conforts")
            ->leftJoin('room_type_conforts tc', 'tc.id_room_type', '=', 'room_types.id')
            ->where(RoomType::STATE, RoomType::_STATE_ENABLED)
            ->groupBy('room_types.id')
            ->orderBy(RoomType::ORDER_BY)
            ->get();

        if (Auth::isAPI()) {
            return $items;
        }

        return view('room_types')->set('items', $items);
    }

    public function create(Req $req)
    {
        $item = RoomType::find($req->num('id'));
        $item->data('id_user', Auth::id());
        $item->data('name', $req->any('name'));
        $item->data('description', $req->any('description'));
        $item->data('cost', $req->num('cost'));
        $item->data('price', $req->num('price'));
        $item->data('max_pax', $req->num('max_pax'));
        $item->data('min_stay', $req->num('min_stay'));

        $id_conforts = $req->arr('id_conforts');

        if (empty($item->name)) {
            return rsp('Ingresa un nombre');

        } else {

            $rsp = $item->createOrUpdateRSP();

            if ($rsp->ok) {

                QB::table('room_type_conforts')->where('id_room_type', $rsp->id)->delete();

                foreach ($id_conforts as $id_confort) {
                    QB::table('room_type_conforts')->insert([
                        'id_room_type' => $rsp->id,
                        'id_type_confort' => $id_confort
                    ]);
                }

            }

            return $rsp;
        }
    }

    public function item($id)
    {
        $item = RoomType::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return RoomType::deleteRSP($req->num('id'));
    }

    public function dataForm()
    {
        return rsp(true)
            ->set('conforts', Type::where('type', Type::CONFORT)->get());
    }
}
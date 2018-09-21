<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Box;
use Models\Branch;
use Models\Client;
use Models\Log;
use Models\Module;
use Models\Printer;
use Models\Product;
use Models\Provider;
use Models\Role;
use Models\Room;
use Models\RoomType;
use Models\Turn;
use Models\Type;
use Models\Unit;
use Models\User;

class logs extends _controller
{

    public function index(Req $req)
    {
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'desc'))
            ->set('sort_by', $req->any('sort_by', 'date_created'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('id_user', $req->num('id_user'))
            ->set('type', $req->num('type'));

        $qb = QB::table('logs');
        $qb->select('logs.*', 'users.name us_name', 'users.surname us_surname');
        $qb->join('users', 'users.id', '=', 'logs.id_user');

        //exit(QB::raw('DATE(date_created)'));

        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(logs.date_created)', $fils->date_from, $fils->date_to);

        if ($fils->id_user > 0)
            $qb->where('id_user', '=', $fils->id_user);

        if ($fils->type > 0)
            $qb->where('logs.type', '=', $fils->type);

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);

        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items', $qb->get());

        foreach ($fils->items as &$item) {
            switch ($item->target) {
                case 'clients':
                    $item->target = 'al cliente <b>' . Client::find($item->id_ref)->nombre . '</b>';
                    break;
                case 'providers':
                    $item->target = 'al proveedor <b>' . Provider::find($item->id_ref)->name . '</b>';
                    break;
                case 'printers':
                    $item->target = 'la impresora <b>' . Printer::find($item->id_ref)->name . '</b>';
                    break;
                case 'users':
                    $item->target = 'al usuario <b>' . User::find($item->id_ref)->name . '</b>';
                    break;
                case 'roles':
                    $item->target = 'el rol de usuario <b>' . Role::find($item->id_ref)->name . '</b>';
                    break;
                case 'branches':
                    $item->target = 'la sucursal <b>' . Branch::find($item->id_ref)->name . '</b>';
                    break;
                case 'room_types':
                    $item->target = 'el tipo de habitación <b>' . RoomType::find($item->id_ref)->name . '</b>';
                    break;
                case 'rooms':
                    $item->target = 'la habitación <b>' . Room::find($item->id_ref)->name . '</b>';
                    break;
                case 'boxes':
                    $item->target = 'la caja <b>' . Box::find($item->id_ref)->name . '</b>';
                    break;
                case 'turns':
                    $item->target = 'el turno <b>' . Turn::find($item->id_ref)->name . '</b>';
                    break;
                case 'modules':
                    $item->target = 'el modulo <b>' . Module::find($item->id_ref)->name . '</b>';
                    break;
                case 'units':
                    $item->target = 'la unidad <b>' . Unit::find($item->id_ref)->name . '</b>';
                case 'products':
                    $item->target = 'el producto <b>' . Product::find($item->id_ref)->name . '</b>';
                    break;
                case 'types':
                    $type = Type::find($item->id_ref);
                    switch ($type->type) {
                        case Type::CLIENT:
                            $item->target = 'el tipo de cliente <b>' . $type->name . '</b>';
                            break;
                        case Type::DOCUMENT:
                            $item->target = 'el tipo de documento <b>' . $type->name . '</b>';
                            break;
                        case Type::PROOF:
                            $item->target = 'el tipo de comprobante <b>' . $type->name . '</b>';
                            break;
                        case Type::METHOD:
                            $item->target = 'el método de pago <b>' . $type->name . '</b>';
                            break;
                        case Type::CONFORT:
                            $item->target = 'la comodidad de habitación <b>' . $type->name . '</b>';
                            break;
                        case Type::PROCAT:
                            $item->target = 'la categoría de producto <b>' . $type->name . '</b>';
                            break;
                        case Type::BRAND:
                            $item->target = 'la marca <b>' . $type->name . '</b>';
                            break;
                    }
                    break;
            }
        }

        if (Auth::isAPI()) {
            return $fils;
        }

        return view()
            ->set('types', [
                '1' => 'Sesión iniciada',
                '2' => 'Sesión cerrada',
                '3' => 'Creación',
                '4' => 'Actualización',
                '5' => 'Eliminación'
            ])
            ->set('fils', $fils);
    }

    public function item($id)
    {
        $item = Log::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Log::deleteRSP($req->num('id'));
    }

}
<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Event;
use Models\Type_notification;

class events extends _controller
{

    //get all events
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

        $qb = QB::table('events');
        $qb->where('events.state', '!=', Event::_STATE_DELETED);

        //exit(QB::raw('DATE(date_created)'));


        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        if (!empty($fils->word))
            $qb->where('events.name', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);
        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items',  QB::query('    SELECT e.id, e.id_station, e.direction, e.type, tn.notificacion, e.name, e.date, 
                                                e.state, e.date_created, e.date_updated, e.date_deleted 
                                                FROM events e 
                                                INNER JOIN
                                                stations et ON 
                                                e.id_station = et.id 
                                                INNER JOIN
                                                type_notifications tn ON 
                                                e.type = tn.id 
                                                where e.state = "1" and tn.state="1"')->get());

        if (Auth::isAPI()) {
            return $fils;
        }

        return view('events')
           // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
            ->set('fils', $fils);
    }

    //create events
    public function create(Req $req)
    {
        $item = Event::find($req->num('id'));
        $item->data('id_station', $req->num('id_station'));
        $item->data('direction', $req->any('direction'));
        $item->data('type', $req->any('type'));
        $item->data('name', $req->num('name'));
        $item->data('date', $req->num('date'));

        if (empty($item->name)) {
            return rsp('Ingresa un Nombre');
        } else {
            return $item->createOrUpdateRSP();
        }
    }

    //get events by id
    public function item($id)
    {
        $item = Event::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    //edit events
    public function edit($id)
    {
        $item = Event::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm($id = 0){
        $id = _REQ_INT('id');
        return rsp(true)
            //->set('item', $id > 0 ? Event::find($id) : null)
         ->set('item', $id > 0 ? QB::query('SELECT e.id, e.id_station, e.direction, e.type, e.name, e.date, 
                                                e.state, e.date_created, e.date_updated, e.date_deleted 
                                                FROM events e 
                                                INNER JOIN
                                                stations et ON 
                                                e.id_station = et.id 
                                                INNER JOIN
                                                type_notifications tn ON 
                                                e.type = tn.id 
                                                where e.id = '.$id.' ')->first() : null)
            ->set('type_notifications', Type_notification::all())
            ->set('stations', QB::query('SELECT id, name, district, address, lat, lng FROM stations')->get())
            ->set('messages', QB::query('SELECT m.id, m.parent_type, tn.notificacion, m.select, m.message, m.state, m.date_created 
                                                FROM messages m 
                                                INNER JOIN 
                                                type_notifications tn ON 
                                                m.parent_type = tn.id 
                                                WHERE m.state = "1" & tn.state= "1"')->get());
        // ->set('type_clients', Type::where('type', Type::CLIENT)->get())
        // ->set('type_documents', Type::where('type', Type::DOCUMENT)->get())
        // ->set('countries', Country::all());
    }


    public function remove(Req $req)
    {
        return Event::deleteRSP($req->num('id'));
    }

}
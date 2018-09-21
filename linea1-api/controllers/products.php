<?php namespace Controllers;

use Inc\Auth;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Product;
use Models\Type;
use Models\Unit;

class products extends _controller
{

    public function index(Req $req)
    {
        $fils = new \stdClass();
        $fils->max = $req->num('max', 10);
        $fils->page = $req->num('page', 1);
        $fils->sort = $req->any('sort', 'asc');
        $fils->sort_by = $req->any('sort_by', 'name');
        $fils->word = $req->any('word');
        $fils->id_role = $req->num('id_role');
        $fils->state = $req->num('state');
        $fils->offset = ($fils->page - 1) * $fils->max;

        $qb = QB::table('products pr');
        $qb->select('pr.*', 'ca.name category_name');
        $qb->join('types ca', 'ca.id', '=', 'pr.id_category');
        $qb->join('units un', 'un.id', '=', 'pr.id_unit');

        $qb->where('pr.state', '!=', Product::_STATE_DELETED);

        if (!empty($fils->word))
            $qb->where("CONCAT(pr.name)", 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

        $qb->offset($fils->offset);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);

        $fils->total = $qb->count();
        $fils->pages = ceil($fils->total / $fils->max);

        $fils->items = $qb->get();

        if (Auth::isAPI()) {
            return $fils;
        }

        return view()->set('fils', $fils);
    }

    public function form($id = 0)
    {
        $item = new Product();

        if ($id > 0) {

            $qb = QB::table('products pr')
                ->select('pr.*', 'pv.name provider_name')
                ->leftJoin('providers pv', 'pv.id', '=', 'pr.id_provider')
                ->where('pr.id', $id)
                ->asObject(Product::class);

            $item = $qb->first() or done('Not found');
        }

        return view(self::$module . '_form')
            ->title($item->exist() ? 'Editar producto' : 'Agregar producto')
            ->set('item', $item)
            ->set('categories', Type::get(Type::PROCAT))
            ->set('units', Unit::all())
            ->set('brands', Type::get(Type::BRAND));
    }

    public function create(Req $req)
    {
        $item = Product::find($req->num('id'));

        $item->data('id_user', Auth::id());
        $item->data('type', $req->num('type'));
        $item->data('code', $req->any('code'));
        $item->data('name', $req->any('name'));
        $item->data('id_category', $req->num('id_category'));
        $item->data('id_brand', $req->num('id_brand'));
        $item->data('id_unit', $req->num('id_unit'));
        $item->data('id_unit_buy', $req->num('id_unit_buy'));
        $item->data('id_unit_sell', $req->num('id_unit_sell'));
        $item->data('min_stock', $req->num('min_stock'));
        $item->data('cost', $req->num('cost'));
        $item->data('price', $req->num('price'));
        $item->data('id_provider', $req->num('id_provider'));
        $item->data('details', $req->any('details'));
        $item->data('featured', $req->num('featured'));

        if ($item->type <= 0) {
            return rsp('Elija el tipo de producto');

        } else if (empty($item->code)) {
            return rsp('Ingrese el código');

        } else if (empty($item->name)) {
            return rsp('Ingrese el nombre');

        } else if ($item->id_category <= 0) {
            return rsp('Elija la categoría');

        } else if ($item->id_unit <= 0) {
            return rsp('Elija la unidad');

        } else if ($item->cost <= 0) {
            return rsp('Ingrese el costo');

        } else if ($item->price <= 0) {
            return rsp('Ingrese el precio');

        } else {
            return $item->createOrUpdateRSP();
        }
    }

    public function item($id)
    {
        $item = Product::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function remove(Req $req)
    {
        return Product::deleteRSP($req->num('id'));
    }

}
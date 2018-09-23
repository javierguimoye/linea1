<?php namespace Controllers;


use Inc\DB;
use Inc\Req;
use Libs\Pixie\QB;
use Models\Saldo;
use mysqli;

class saldos extends _controller
{

    public function index(Req $req)
    {
        $fils = rsp(true)
            ->set('max', $req->num('max', 10))
            ->set('page', $req->num('page', 1))
            ->set('sort', $req->any('sort', 'asc'))
            ->set('sort_by', $req->any('sort_by', 'id'))
            ->set('date_from', $req->date('date_from'))
            ->set('date_to', $req->date('date_to'))
            ->set('word', $req->any('word'));

        $qb = Saldo::where('state', '!=', Saldo::_STATE_DELETED);

        if (!empty($fils->date_from) && !empty($fils->date_to))
            $qb->whereBetween('DATE(date_created)', $fils->date_from, $fils->date_to);

        //if (!empty($fils->word))
        //    $qb->where('name', 'LIKE', '%' . str_replace(' ', '%', $fils->word) . '%');

        $qb->offset(($fils->page - 1) * $fils->max);
        $qb->limit($fils->max);
        $qb->orderBy($fils->sort_by, $fils->sort);

        $items = [];
        foreach ($qb->get() as $o) {

            $o->file_url = empty($o->file) ? '' : URL_BASE . 'uploads/' . $o->file;

            $items[] = $o;
        }

        $fils->set('total', $qb->count());
        $fils->set('pages', ceil($fils->total / $fils->max));
        $fils->set('items', $items);

        return $fils;
    }

    /**
     * @param Req $req
     * @return \Inc\Rsp
     */
    public function create(Req $req){
        $listMeses  = array( 'ENE'  , 'FEB' , 'MAR' ,  'ABR', 'MAY' , 'JUN' , 'JUL' , 'AGO' , 'SET' , 'OCT' , 'NOV', 'DIC',);
        $listMesesN = array( '01'   , '02'  , '03'  ,  '04' , '05'  , '06'  , '07'  , '08'  , '09'  , '10'  , '11', '12',);

        $item = Saldo::find($req->num('id'));
       // $item->data('name', $req->any('name'));

       // if (empty($item->name)) {
      //      return rsp('Ingresa un nombre');
      //  } else {
        $r = $item->createOrUpdateRSP();
        $pic=null;
            if ($r->ok) {
                $file = @$_FILES['file'];
                if (isset($file['tmp_name']) && !empty($file['tmp_name'])) {
                    $pic = 'document_sig_' . $r->id . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                    if (@move_uploaded_file($file['tmp_name'], _PATH_ . 'uploads/' . $pic)) {
                        if (Saldo::find($r->id)->update(['file' => $pic . '?t=' . time()])) {
                            //../uploads/document_sig_39.txt

                            $archivo    =   fopen(_PATH_."uploads/".$pic,"r") or die ("problemsa al abrir archivo.txt");
                            $arreglo    =   null;
                            $sql        =   "";
                            $pdo        =   DB::getCN();
                            $sql        =   $pdo->prepare("INSERT INTO cards (dni, number, amount, 	date_updated) VALUES (:dni, :number, :amount, :date_updated)");
                            $pdo->beginTransaction();

                            try {
                            while (!feof($archivo)) {
                                $traer = fgets($archivo);
                                $arreglo = explode("|", $traer);

                                if(count($arreglo)==5){
                                    $fecha=$arreglo[0];
                                    $hora=$arreglo[1];
                                    $documento=$arreglo[2];
                                    $tarjeta=$arreglo[3];
                                    $saldo=$arreglo[4];

                                    if($fecha!='Fecha'){

                                        $array = explode("-", $fecha);
                                        for ($i = 0; $i <= sizeof($listMeses)-1; $i++) {

                                            if($listMeses[$i]==$array[1]){
                                                $fecha='20'.$array[2].'-'.$listMesesN[$i].'-'.$array[0];
                                                $fechas=$fecha.' '.$hora;
                                                $sql->execute([
                                                    ":dni" => $documento,
                                                    ":number" =>$tarjeta,
                                                    ":amount" => $saldo,
                                                    ":date_updated" =>$fechas
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                                $pdo->commit();
                            } catch( PDOException $e ) {
                                $pdo->rollBack(); // Regresarrrr
                                exit("ERRR¡ORRR");
                            }

                        } else {
                            $response['msg'] = 'Error DB :: update_pic';
                        }
                    } else {
                        $response['msg'] = 'error_upload_image';
                    }
                }
            }

          return $r;
       // }
    }

    public function item($id)
    {
        $item = Saldo::find($id);

        if ($item->exist()) {
            return rsp(true)->merge($item);
        } else {
            return rsp('No se reconoce');
        }
    }

    public function dataForm(Req $req)
    {
        $item = Saldo::find($req->num('id'));
        $item->file_url = empty($item->file) ? '' : URL_BASE . 'uploads/' . $item->file;

        return rsp(true)
            ->set('item', $item);
    }

    public function remove(Req $req)
    {
        return Saldo::deleteRSP($req->num('id'));
    }

}
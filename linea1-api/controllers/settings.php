<?php namespace Controllers;

use Inc\Req;
use Inc\STG;
use Models\Country;
use Models\Setting;

class settings extends _controller
{

    public function index()
    {
        return rsp(true)
            ->set('item', STG::all());
    }

    public function saveGeneral(Req $req)
    {
        return $this->_saveAndRSP([
            'brand' => $req->any('brand'),
            'menu_lateral' => $req->num('menu_lateral'),
            'key_firebase' => $req->any('key_firebase'),
            'key_maps' => $req->any('key_maps'),
            'coin' => @$_REQUEST['coin'],
            'coin_short' => $req->any('coin_short'),
            'coin_name' => $req->any('coin_name'),
            'coin2' => @$_REQUEST['coin2'],
            'coin2_short' => $req->any('coin2_short'),
            'coin2_name' => $req->any('coin2_name'),
            'igv' => $req->num('igv'),
            'tc' => $req->num('tc'),
            'interval' => $req->num('interval'),
            'version' => $req->any('version')
        ]);
    }

    public function saveAll(Req $req)
    {
        return $this->_saveAndRSP([
            'brand' => $req->any('brand'),
            'menu_lateral' => $req->num('menu_lateral'),
            'key_firebase' => $req->any('key_firebase'),
            'key_maps' => $req->any('key_maps'),
            'coin' => @$_REQUEST['coin'],
            'coin_short' => $req->any('coin_short'),
            'coin_name' => $req->any('coin_name'),
            'coin2' => @$_REQUEST['coin2'],
            'coin2_short' => $req->any('coin2_short'),
            'coin2_name' => $req->any('coin2_name'),
            'igv' => $req->num('igv'),
            'tc' => $req->num('tc'),
            'interval' => $req->num('interval'),
            'version' => $req->any('version'),

            'name' => $req->any('name'),
            'ruc' => $req->any('ruc'),
            'id_country' => $req->num('id_country'),
            'address' => $req->any('address'),
            'lat' => $req->num('lat'),
            'lng' => $req->num('lng'),
            'email' => $req->any('email'),
            'phone' => $req->any('phone'),
            'fax' => $req->any('fax'),

            'mail_sender' => $req->any('mail_sender'),
            'mail_bcc' => $req->any('mail_bcc'),
            'mail_auth' => $req->num('mail_auth'),
            'mail_host' => $req->any('mail_host'),
            'mail_username' => $req->any('mail_username'),
            'mail_password' => $req->any('mail_password')
        ]);
    }

    public function saveMail(Req $req)
    {
        return $this->_saveAndRSP([
            'mail_sender' => $req->any('mail_sender'),
            'mail_bcc' => $req->any('mail_bcc'),
            'mail_auth' => $req->num('mail_auth'),
            'mail_host' => $req->any('mail_host'),
            'mail_username' => $req->any('mail_username'),
            'mail_password' => $req->any('mail_password')
        ]);
    }

    public function saveCompany(Req $req)
    {
        return $this->_saveAndRSP([
            'name' => $req->any('name'),
            'ruc' => $req->any('ruc'),
            'id_country' => $req->num('id_country'),
            'address' => $req->any('address'),
            'lat' => $req->num('lat'),
            'lng' => $req->num('lng'),
            'email' => $req->any('email'),
            'phone' => $req->any('phone'),
            'fax' => $req->any('fax')
        ]);
    }

    private function _saveAndRSP($items)
    {
        foreach ($items as $name => $value) {
            Setting::where('name', $name)->update(['value' => $value]);
        }
        return rsp(true);
    }

}
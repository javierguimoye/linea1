<?php namespace Models;

class Country extends _model
{
    const ORDER_BY = 'name';

    protected $table = 'countries';

    public $id;
    public $name;
    public $state;
}
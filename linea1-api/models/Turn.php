<?php namespace Models;

class Turn extends _model {

    const ORDER_BY = 'name';

    public $id;
    public $name;
    public $time_from;
    public $time_to;
    public $state;

}
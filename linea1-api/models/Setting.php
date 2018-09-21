<?php namespace Models;

class Setting extends _model {

    protected $attr_id = 'name';
    const STATE = null;

    public $name;
    public $value;
    public $description;

}
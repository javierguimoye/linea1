<?php namespace Models;

class Type extends _model
{

    const ORDER_BY = 'sort';

    const CLIENT = 1;
    const DOCUMENT = 2;
    const PROOF = 3;
    const METHOD = 4;
    const CONFORT = 5; // Comodidad
    const PROCAT = 6; // Categoria de producto
    const SUPCAT = 7; // Categoria de insumo
    const BRAND = 8; // Marca de producto

    /* @var int */
    public $type;
    /* @var string */
    public $name;
    /* @var string */
    public $code;
    /* @var int */
    public $state;

    public static function get($type)
    {
        return self::where('type', $type)->get();
    }

}
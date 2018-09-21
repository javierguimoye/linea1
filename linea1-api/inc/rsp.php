<?php namespace Inc;

class Rsp extends \stdClass {

    public $ok = false;
    public $msg = '---';

    /**
     * @param string $k
     * @param mixed $v
     * @return Rsp
     */
    function set($k, $v){
        $this->$k = $v;
        return $this;
    }

    /**
     * Combinar un objeto / array
     * @param array|object $obj_or_arr
     * @return Rsp
     */
    function merge($obj_or_arr){
        //$items = (array) $obj_or_arr;
        foreach($obj_or_arr as $k => $v){
            $this->set($k,$v);
        }
        return $this;
    }

    public function __toString()
    {
        return json_encode($this);
    }

}
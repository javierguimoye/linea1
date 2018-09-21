<?php namespace Inc;

class Req extends \stdClass {

    public function __construct($items = null)
    {
        $this->setAll($items);
    }

    function any($name, $default_value='')
    {
        $val = @trim(@$this->$name);
        return !empty($val) ? $val : $default_value;
    }

    function num($name, $default_value=0)
    {
        $val = @$this->$name;
        return is_numeric($val) ? $val+0 : $default_value;
    }

    function date($name, $default_value = '')
    {
        $val = @$this->$name;
        return !empty($val) && Util::isDate($val) ? $val : $default_value;
    }

    function arr($name, $default_value=[])
    {
        $val = @$this->$name;
        return is_array($val) ? $val : $default_value;
    }

    function setAll($items){
        if ($items != null) {
            foreach ($items as $k => $v) {
                $this->$k = $v;
            }
        }
    }

}
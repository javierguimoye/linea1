<?php namespace Inc;

use Smarty;

class View{

    /* @var string */   private $name;
    /* @var array */    private $vars;
    /* @var string */   private $title;

    public function __construct()
    {
        $this->name = 'undefined';
        $this->vars = [];
        $this->title = Perms::current() ? Perms::current()->name : stg('brand');
    }

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function set($k, $v)
    {
        $this->vars[$k] = $v;
        return $this;
    }

    public function build()
    {
        $file_name = $this->name.'.tpl';

        if(!file_exists(_PATH_.'views/'.$file_name))
        {
            return 'La vista :'.$file_name.' no existe';

        } else {

            STG::set('user', Auth::user());

            $smarty = new Smarty;
            $smarty->setCompileDir('libs/smarty/templates_c');
            $smarty->setCacheDir('libs/smarty/cache');
            $smarty->setTemplateDir('views');
            $smarty->assign('stg', STG::all());
            $smarty->assign('menu', Perms::menuSorted());
            $smarty->assign('shortcuts', Perms::shortcuts());
            foreach($this->vars as $k => $v){
                $smarty->assign($k, $v);
            }
            $smarty->assign('page_title', $this->title);

            return $smarty->fetch($file_name);

        }

    }

    public function __toString()
    {
        return $this->build();
    }

}
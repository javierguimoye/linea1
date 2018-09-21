<?php namespace Inc;
use Controllers\_controller;
use ReflectionMethod;

/**
 * Class Route
 *
 * ========================
 * Manual
 * $router = new Router();
 * $router->add('foo/:num', 'controller', 'method');
 * $router->add('foo/:any', 'controller', 'method');
 * $router->add('foo/(expresion_regular)/(.*)', 'controller', 'method');
 *
 * ========================
 * Dinamico
 *
 * uso: $route->add(':any', '%', '%');
 *
 * Aplica para:
 *
 * /foo             -> $foo->index();
 * /foo/bar         -> $foo->bar();
 * /foo/50          -> $foo->item(50);
 * /foo/50/bar      -> $foo->bar(50);
 * /foo/50/60/bar   -> $foo->bar(50,60);
 * /foo/bar/50      -> $foo->bar(50);
 * /foo/bar/50/60   -> $foo->bar(50,60);
 */
class Route{

    public static $method       = 'index';

    // Lista de URI para coincidir con
    private $routes = array();

    /**
     * @param $uri
     * @param $controller
     * @param string $method
     */
    public function add($uri, $controller, $method = 'index'){
        $this->routes[$uri] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Busca una coincidencia para el URI y ejecuta la función relacionada
     */
    public function send(){
        $uri = _GET('uri');// TODO: inicio

        define('URI', $uri);

        $segs = empty($uri) ? array() : explode('/', $uri);
        $segs_count = count($segs);

        $args = $segs;

        // Lista a través de los URI almacenados
        foreach($this->routes as $key => $item){

            $key = str_replace(':any', '(.+)', str_replace(':num', '([0-9]+)', $key));

            $useAutomatic = false;

            if(isset($segs[0]) && $item['controller'] == '%'){
                $item['controller'] = $segs[0];
                $useAutomatic = true;
            }

            if($item['method'] == '%'){
                //$item['method'] = ($segs_count>1) ? $segs[$segs_count-1] : 'index';
                $item['method'] = ($segs_count>1) ? $segs[1] : 'index';

                if(is_numeric($item['method']) && $segs_count > 2){
                    $item['method'] = $segs[$segs_count-1];
                }

                if(is_numeric($item['method'])){
                    $item['method'] = 'item';
                }

                $useAutomatic = true;
            }

            //Ver si hay un partido
            if(preg_match("#^".$key."$#", $uri, $preg_output)){

                if($useAutomatic){
                    $this->unsetValue($args, $item['controller']);
                    $this->unsetValue($args, $item['method']);
                    $this->validate($item['controller'], $item['method'], $args);
                } else {
                    unset($preg_output[0]); // el primer valor es uri
                    $this->validate($item['controller'], $item['method'], $preg_output);
                }

                return;
            }

        }

        if (empty($uri)) {
            $cc = new _controller(true);
            $cc->goHome();

        } else {
            $this->show404('Ruta desconocida');
        }

    }

    function unsetValue(&$array, $value, $strict = FALSE){
        //echo 'unset: '.$value."\n";
        if(($key = array_search($value, $array, $strict)) !== FALSE) {
            unset($array[$key]);
        }
    }

    private function validate($controller, $method, $args = array()){

        $controller_namespace = 'Controllers\\'.$controller;

        if(class_exists($controller_namespace))
        {
            self::$method       = $method;

            $cc = new $controller_namespace();
            if(method_exists($cc, $method))
            {
                if(is_callable(array($cc, $method)))
                {
                    $refl       = new ReflectionMethod($cc, $method);
                    $numParams  = $refl->getNumberOfRequiredParameters();
                    $params     = $refl->getParameters();

                    if (count($params) > 0 && $params[0]->name == 'req') {
                        $request_body = file_get_contents('php://input');
                        $args[0] = new Req(json_decode($request_body)?:$_REQUEST);
                    }

                    if(count($args) >= $numParams)
                    {

                        $r = call_user_func_array(array($cc, $method), $args);

                        if($r instanceof View)
                        {
                            echo $r->build();
                        }
                        else if(is_array($r) || is_object($r))
                        {

                            header('Content-Type: application/json');
                            echo json_encode($r);

                        } else {
                            echo $r;
                        }

                    } else done('Se espera ('.$numParams.') parametros, hay ('.count($args).')->('.implode(', ',$args).') en el metodo: '.$method);
                } else done('Este metodo es privado: '.$method);
            } else done('Metodo no existe: '.$method);
        } else $this->show404('Controlador no existe: '.$controller);
    }

    private function show404($text = ''){
        $cc = new _controller(false);
        done($text);
    }

}
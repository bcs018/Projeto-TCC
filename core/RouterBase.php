<?php
namespace core;

use \src\Config;
use \src\models\SelecionaSite;

class RouterBase {

    public function run($routes) {
        $method = Request::getMethod();
        $url = Request::getUrl();

        // Define os itens padrão
        $controller = Config::ERROR_CONTROLLER;
        $action = Config::DEFAULT_ACTION;
        $args = [];

        if(isset($routes[$method])) {
            foreach($routes[$method] as $route => $callback) {
                // Identifica os argumentos e substitui por regex
                $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $route);

                // Faz o match da URL
                if(preg_match('#^('.$pattern.')*$#i', $url, $matches) === 1) {
                    array_shift($matches);
                    array_shift($matches);

                    // Pega todos os argumentos para associar
                    $itens = array();
                    if(preg_match_all('(\{[a-z0-9]{1,}\})', $route, $m)) {
                        $itens = preg_replace('(\{|\})', '', $m[0]);
                    }

                    // Faz a associação
                    $args = array();
                    foreach($matches as $key => $match) {
                        $args[$itens[$key]] = $match;
                    }

                    // Seta o controller/action
                    $callbackSplit = explode('@', $callback);
                    $controller = $callbackSplit[0];
                    if(isset($callbackSplit[1])) {
                        $action = $callbackSplit[1];
                    }

                    break;
                }
            }
        }

        if($_SERVER['HTTP_HOST'] == 'bw.com.br'){
            $controller = "\src\controllers\\$controller";
            $definedController = new $controller();
    
            $definedController->$action($args);
        }else{
            $sub = explode('.', $_SERVER['HTTP_HOST']);

            $site = new SelecionaSite;
            $subBd = $site->listaSubDominio($sub[0]);

            if(isset($subBd['sub_dominio'])){
                if($subBd['sub_dominio'] == $sub['0']){
                    echo "<br>OK<br>";
                    exit;
                }
            }
            else{
                $controller = Config::ERROR_CONTROLLER;
                $action = Config::DEFAULT_ACTION;
            }
            $controller = "\src\controllers\\$controller";
            $definedController = new $controller();

            $definedController->$action($args);
        }

        // $sub = explode('.', $_SERVER['HTTP_HOST']);

        // $site = new SelecionaSite;
        // $subBd = $site->listaSubDominio($sub[0]);

        // if($subBd['sub_dominio'] == $sub['0']){
        //     echo "<br>OK<br>";
        //     exit;
        // }else{
        //     echo "<br>NAO OK<br>";
        //     exit;
        // }
        // $controller = "\src\controllers\\$controller";
        // $definedController = new $controller();

        // $definedController->$action($args);
    }
    
}
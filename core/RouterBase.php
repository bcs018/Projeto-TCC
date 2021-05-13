<?php
namespace core;

use \src\Config;
use \src\models\SelecionaSite;

class RouterBase {

    public function run($routes, $setFolder) {
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

        // Se o folder for prin significa que é o site principal
        if($setFolder == 'prin'){
            // Seto o controller para a pasta do site principal
            $controller = "\src\controllers\sitePrincipal\\$controller";
            $definedController = new $controller();
    
            $definedController->$action($args);
        }else{
            // Senão eu pego a pasta do ecommerce

            //Pego o HTTP_HOST para validar se existe no banco de dados na tabela ecommerce_usu
            $sub = explode('.', $_SERVER['HTTP_HOST']);

            $site = new SelecionaSite;
            $subBd = $site->listaSubDominio($sub[0]);

            // Se retornar resultado, é pq existe no banco o subdominio, então chama o controller
            if(isset($subBd['sub_dominio'])){
                if($subBd['sub_dominio'] == $sub['0']){
                    $controller = "\src\controllers\commerce\\$controller";
                    $definedController = new $controller();

                    $definedController->$action($args);
                }
            }else{
                // Senão chama o ErroController para dar 404
                $controller = "\src\controllers\sitePrincipal\\".Config::ERROR_CONTROLLER;
                $action = Config::DEFAULT_ACTION;

                $definedController = new $controller();

                $definedController->$action($args);
            }
            
        }
    }
    
}
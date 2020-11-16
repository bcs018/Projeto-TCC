<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Home;

class HomeController extends Controller {

    public function index() {
        $home = new Home();
        $dominio = $_SERVER['HTTP_HOST'];
        
        $dados['lista'] = $home->get_tenant($dominio);
       
        $this->render('home', $dados);
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}
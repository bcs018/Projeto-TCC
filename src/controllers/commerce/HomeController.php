<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\Plano;

class HomeController extends Controller {

    public function index() {   
        echo "ENTREI NO HOME CONTROLLER";
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}
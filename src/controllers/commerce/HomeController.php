<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Info;

class HomeController extends Controller {

    public function index() {
        $info = new Info;

        $this->render('commerce/lay01/home', ['dados'=>$info->pegaDadosCommerce($_SESSION['sub_dom'])]);

    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}
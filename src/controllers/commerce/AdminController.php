<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;

class AdminController extends Controller {

    public function index() {
        $this->render('commerce/lay01/login_adm');

    }

    public function logar() {
        $login = new Admin;
        
    }

    public function sobreP($args) {
        print_r($args);
    }

}
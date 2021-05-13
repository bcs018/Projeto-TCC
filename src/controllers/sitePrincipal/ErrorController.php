<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;

class ErrorController extends Controller {

    public function index() {
        $this->render('sitePrincipal/404');
    }

}
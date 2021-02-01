<?php
namespace src;

define('BASE_ASS', 'http://bw.com.br/assets/sitePrincipal/');

class Config {
    const BASE_DIR = '/projeto-tcc';

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'ecommerce';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}
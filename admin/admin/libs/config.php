<?php

//constantes de url
define('URL_SITE','http://localhost');
define('URL_ADMIN','http://localhost/admin');

//constantes de diretorio
define('DIR_SEP','\\');
$path = pathinfo(__FILE__);
define('DIR_HOME',str_replace(DIR_SEP."libs","",$path['dirname']));


//registro de autoload
require_once("autoload.php");

//registro de funções padrões
require_once("functions.php");

//define titulo
define('TITLE','GFG E-commerce - Lojas virtuais completas');

//define linguagem padrao
define('ID_LANGUAGE','1');

//constantes de banco de dados $hostname, $username, $password, $database
define('DB_HOSTNAME','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DATABASE','gfgecommerce');

?>
<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 09/09/2015
 * Time: 23:01
 */
require_once('libs/config.php');

if(isset($_GET['_route_']) && $_GET['_route_']){
	$requests = explode('/', $_GET['_route_']);

	for($i = 0; $i < count($requests); $i++){
		if($requests[$i] == 'list'){
			$_GET['class'] = $requests[$i + 1];
			Functions::callList();
		}elseif($requests[$i] == 'form'){
			$_GET['class'] = $requests[$i + 1];
			$_GET['id_table'] = $requests[$i + 2];
			Functions::callForm();
		}elseif($requests[$i] == 'delete'){
			$_GET['id_table'] = $requests[$i + 2];
			$class_initialized = 'Controller' . ucfirst($requests[$i + 1]);
			$class_initialized = new $class_initialized();
			$var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $class_initialized->construct['id_table'])));
			$class_initialized->$var($requests[$i + 2]);
			$class_initialized->delete();
			Functions::callReloadDelete($requests[$i + 1]);
		}
	}
}else{
	Functions::callHeader();
}
Functions::callFooter();
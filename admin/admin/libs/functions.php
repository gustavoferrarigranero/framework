<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/09/2015
 * Time: 12:20
 */

class Functions{

	public static function converteStd($array){
		return (object)$array;
	}

	public static function callHeader(){
		require_once(DIR_HOME . "/header.php");
	}

	public static function callFooter(){
		require_once(DIR_HOME . "/footer.php");
	}

	public static function callList(){
		require_once(DIR_HOME . DIR_SEP . "list.php");
	}

	public static function callForm(){
		require_once(DIR_HOME . DIR_SEP . "form.php");
	}

	public static function callReloadDelete($class){
		header('Location: '.URL_ADMIN . '/list/' . $class . '/');
	}

}
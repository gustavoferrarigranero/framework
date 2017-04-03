<?php
function __autoload($classname){

	if(file_exists(DIR_HOME . '/controller/'.$classname.'.php'))
		require_once(DIR_HOME . '/controller/'.$classname.'.php');

	if(file_exists(DIR_HOME . '/model/'.$classname.'.php'))
		require_once(DIR_HOME . '/model/'.$classname.'.php');

	if(file_exists(DIR_HOME . '/libs/'.$classname.'.php'))
		require_once(DIR_HOME . '/libs/'.$classname.'.php');

}
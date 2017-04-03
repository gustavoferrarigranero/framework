<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/09/2015
 * Time: 09:29
 */

class ModelCategory extends Model{

	public $construct = array(
		'fields' => array(
			'id_category' => array('insert'=> false,'update'=> false,'list' => true,'form' => true,'title' => 'Código','col'=>1)/*adiciona defaults*/,
			'status' => array('insert'=> true,'update'=> true,'list' => true,'form' => true,'title' => 'Status','type' => 'status','col'=> 2)/*adiciona defaults*/,
		),
		'fields_lang' => array(
			'id_category_lang' => array('insert'=> false,'update'=> false,'list' => false,'form' => false)/*adiciona defaults*/,
			'id_category' => array('insert'=> true,'update'=> true,'list' => false,'form' => false)/*adiciona defaults*/,
			'id_language' => array('insert'=> true,'update'=> false,'list' => false,'form' => false)/*adiciona defaults*/,
			'name' => array('insert'=> true,'update'=> true,'list' => true,'form' => true,'title' => 'Nome')/*adiciona defaults*/,
			'description' => array('insert'=> true,'update'=> true,'list' => true,'form' => true,'title' => 'Descrição','type' => 'description')/*adiciona defaults*/,
		),
		'table' => 'categories',
		'table_lang' => 'categories_lang',
		'id_table' => 'id_category',
		'id_table_lang' => 'id_category_language',
		'id_table_lang_field' => 'id_language',
		'order_by' => 'name',
		'class' => 'Category',
		'title' => 'Categorias',
	);

	public function __construct($action,$id){
		parent::__construct($action,$id);
	}

}
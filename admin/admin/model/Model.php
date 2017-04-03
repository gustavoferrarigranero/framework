<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/09/2015
 * Time: 09:35
 */
class Model{

	/**
	 * @var
	 */
	protected $construct;

	/**
	 * @var
	 */
	protected $fields_values;

	/**
	 * @var
	 */
	public $db;

	/**
	 *
	 * @param $action traz a ação da classes para ser executada
	 * @param $id registra o id da classe para instanciar o new Object
	 */
	protected function __construct($action = false,$id = 0){

		$this->db = Connection::getDb();

		if($action){
			$this->actions($action);
		}

		if($id){
			$this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']] = $id;
			$this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']] = ID_LANGUAGE;
			$this->get();
		}

	}

	/**
	 * metodo responsavelpor chamar as ações da classe
	 * @param $action
	 */
	protected function actions($action){

	}

	/**
	 * faz a chamada de get e set do produto
	 * @param $metodo
	 * @param $parametros
	 * @return mixed
	 */
	public function __call($metodo, $parametros) {

		if (substr($metodo, 0, 3) == 'set') {

			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			if (isset($parametros[0]))
				if(isset($this->construct['fields'][$var]) || isset($this->construct['fields_lang'][$var])){
					$this->fields_values[$this->construct['class'].'_'.$var] = $parametros[0] ;
				}

		} elseif (substr($metodo, 0, 3) == 'get') {

			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			if(isset($this->construct['fields'][$var]) || isset($this->construct['fields_lang'][$var])){
				return $this->fields_values[$this->construct['class'].'_'.$var];
			}

		}
	}


	/**
	 * @return bool
	 */
	public function get(){

		if(!isset($this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']]) || !$this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']])
			return false;

		$select = 'SELECT * ';
		$select_lang = '';
		$from = '';
		$where = ' WHERE ';
		$order = '';

		$from .= ' FROM ' . $this->construct['table'] . ' a';

		if(isset($this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']])){
			$from .= ' INNER JOIN ' . $this->construct['table_lang'] . ' b';
			$from .= ' ON  a.' . $this->construct['id_table'] . ' =  b.' . $this->construct['id_table'];
			$where .= ' b.' . $this->construct['id_table_lang_field'] . ' = "' . $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']] . '" AND ';
		}

		$where .= ' a.' . $this->construct['id_table'] . ' = "'. $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']] .'" AND ';

		$query = rtrim($select . $select_lang,', ') . " " . $from . " " . rtrim($where,'AND ') . " LIMIT 1";

		$result = $this->db->query($query);

		$this->fields_values = null;

		if($result->row){
			foreach($result->row as $key => $value){
				$this->fields_values[$this->construct['class'].'_'.$key] = $value;
			}
			return true;
		}else{
			return false;
		}

	}

	/**
	 * @param bool $order
	 * @return mixed
	 */
	public function getList($order = false){

		$select = 'SELECT * ';
		$select_lang = '';
		$from = '';
		$where = '';


		$from .= ' FROM ' . $this->construct['table'] . ' a';

		if(isset($this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']])){
			$from .= ' INNER JOIN ' . $this->construct['table_lang'] . ' b';
			$from .= ' ON  a.' . $this->construct['id_table'] . ' =  b.' . $this->construct['id_table'];
			$where .= ' b.' . $this->construct['id_table_lang_field'] . ' = "' . $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']] . '" AND ';
		}

		$query = rtrim($select . $select_lang,', ') . " " . $from . " " . ($where ? rtrim('WHERE ' . $where,'AND ') : '') . " ";

		if($order)
			$query .= ' ORDER BY '. $order;
		else
			$query .= ' ORDER BY a.'. $this->construct['id_table'] . ' DESC ';

		$query = $this->db->query($query);

		if($query->row){
			return $query->rows;
		}

	}

	/**
	 * @return bool|stdClass
	 */
	public function update(){

		$update = '';
		$sets = '';
		$where = '';

		$update .= 'UPDATE ' . $this->construct['table'] . ' a ';

		if(isset($this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']])){
			$update .= ' INNER JOIN ' . $this->construct['table_lang'] . ' b ';
			$update .= ' ON  a.' . $this->construct['id_table'] . ' =  b.' . $this->construct['id_table'] . ' ';
		}

		$update .= ' SET ';

		foreach($this->fields_values as $key => $value){
			if(isset($this->construct['fields'][str_replace($this->construct['class'].'_','',$key)]) && $this->construct['fields'][str_replace($this->construct['class'].'_','',$key)]['update'])
				$sets .= 'a.' . str_replace($this->construct['class'].'_','',$key) . ' = "' . $value . '", ';
			elseif(isset($this->construct['fields_lang'][str_replace($this->construct['class'].'_','',$key)]) && $this->construct['fields_lang'][str_replace($this->construct['class'].'_','',$key)]['update'])
				$sets .= 'b.' . str_replace($this->construct['class'].'_','',$key) . ' = "' . $value . '", ';
		}

		$where .= ' WHERE a.' . $this->construct['id_table'] . ' = "'. $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']] .'" AND ';

		if(isset($this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']])){
			$where .= ' b.' . $this->construct['id_table_lang_field'] . ' = "' . $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table_lang_field']] . '" AND ';
		}

		$query = $update . rtrim($sets,', ') . ' ' . rtrim($where,'AND ' ) ;

		return $this->db->query($query);

	}

	/**
	 * @return bool|stdClass
	 */
	public function insert(){

		$insert = '';

		$insert .= 'INSERT INTO ' . $this->construct['table'] . ' SET ';

		foreach($this->fields_values as $key => $value){
			if(isset($this->construct['fields'][str_replace($this->construct['class'].'_','',$key)]) && $this->construct['fields'][str_replace($this->construct['class'].'_','',$key)]['insert'])
				$insert .= ' ' . str_replace($this->construct['class'].'_','',$key) . ' = "' . $value . '", ';
		}

		$query = rtrim($insert,', ') ;

		$this->db->query($query);

		$id_create = $this->db->getLastId();

		return $id_create;

	}

	/**
	 * @return bool|stdClass
	 */
	public function insertLang(){

		$insert = '';

		if(isset($this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']]) && $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']]){

			$insert = '';

			$insert .= 'INSERT INTO ' . $this->construct['table_lang'] . ' SET ';

			foreach($this->fields_values as $key => $value){
				if(isset($this->construct['fields_lang'][str_replace($this->construct['class'].'_','',$key)]) && $this->construct['fields_lang'][str_replace($this->construct['class'].'_','',$key)]['insert'])
					$insert .= ' ' . str_replace($this->construct['class'].'_','',$key) . ' = "' . $value . '", ';
			}

			$query = rtrim($insert,', ') ;

			$this->db->query($query);

		}

	}

	/**
	 * @return bool|stdClass
	 */
	public function delete(){

		$success = false;

		if($this->fields_values[$this->construct['id_table']]){

			$delete = 'DELETE FROM ' . $this->construct['table'] . ' WHERE ' . $this->construct['id_table'] . ' = "' . $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']] . '"';

			$success = $this->db->query($delete);

		}

		if($this->construct['table_lang']){

			$delete = 'DELETE FROM ' . $this->construct['table_lang'] . ' WHERE ' . $this->construct['id_table'] . ' = "' . $this->fields_values[$this->construct['class'].'_'.$this->construct['id_table']] . '"';

			$success = $this->db->query($delete);

		}

		return $success;

	}

	public function getField($field){
		if(isset($this->fields_values[$this->construct['class'].'_'.$field])){
			return $this->fields_values[$this->construct['class'].'_'.$field];
		}
	}

	/**
	 * @return mixed
	 */
	public function getLanguages(){

		$select = 'SELECT * ';
		$select_lang = '';
		$from = '';
		$where = '';

		$from .= ' FROM languages a';

		$where .= ' a.status = 1 AND ';

		$query = rtrim($select . $select_lang,', ') . " " . $from . " " . ($where ? rtrim('WHERE ' . $where,'AND ') : '') . " ";

		$query .= ' ORDER BY a.id_language ';

		$query = $this->db->query($query);

		if($query->row){
			return $query->rows;
		}

	}

}

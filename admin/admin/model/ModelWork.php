<?php

/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/09/2015
 * Time: 09:29
 */
class ModelWork extends Model
{

    public $construct = array(
        'fields' => array(
            'id_work' => array('insert' => false, 'update' => false, 'list' => true, 'form' => true, 'title' => 'Código', 'col' => 1)/*adiciona defaults*/,
            'id_category' => array('insert' => false, 'update' => false, 'list' => false, 'form' => true, 'title' => 'Categorias', 'type' => 'content_multiple', 'col' => 10)/*adiciona defaults*/,
            'status' => array('insert' => true, 'update' => true, 'list' => true, 'form' => true, 'title' => 'Status', 'type' => 'status', 'col' => 2)/*adiciona defaults*/,
        ),
        'fields_lang' => array(
            'id_work_lang' => array('insert' => false, 'update' => false, 'list' => false, 'form' => false)/*adiciona defaults*/,
            'id_work' => array('insert' => true, 'update' => true, 'list' => false, 'form' => false)/*adiciona defaults*/,
            'id_language' => array('insert' => true, 'update' => false, 'list' => false, 'form' => false)/*adiciona defaults*/,
            'name' => array('insert' => true, 'update' => true, 'list' => true, 'form' => true, 'title' => 'Nome')/*adiciona defaults*/,
            'description' => array('insert' => true, 'update' => true, 'list' => true, 'form' => true, 'title' => 'Descrição', 'type' => 'description')/*adiciona defaults*/,
        ),
        'table' => 'works',
        'table_lang' => 'works_lang',
        'id_table' => 'id_work',
        'id_table_lang' => 'id_work_language',
        'id_table_lang_field' => 'id_language',
        'order_by' => 'name',
        'class' => 'Work',
        'title' => 'Cases',
    );

    public function __construct($action, $id)
    {
        parent::__construct($action, $id);
    }

    protected function categorySelected()
    {
        $return = $this->db->query('SELECT * from works_categories
			WHERE id_category = ' . (int)$this->getIdCategory() . ' AND id_work = ' . (int)$this->getIdWork());

        if($return->num_rows){
            return $return->rows;
        }else{
            return false;
        }
    }

    protected function deleteCategories()
    {
        return $this->db->query('DELETE FROM works_categories WHERE id_work = ' . (int)$this->getIdWork());
    }

    protected function insertCategories()
    {
        return $this->db->query('INSERT INTO works_categories(id_work,id_category)
			VALUES(' . (int)$this->getIdWork() . ',' . (int)$this->getIdCategory().')');
    }

}
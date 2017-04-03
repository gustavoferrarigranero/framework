<?php

/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/09/2015
 * Time: 10:21
 */
class ControllerWork extends ModelWork
{

    public function __construct($action = false, $id = false)
    {
        parent::__construct($action, $id);

        $controllerCategory = new ControllerCategory();
        $controllerCategory->setIdLanguage(ID_LANGUAGE);
        $this->construct['content_multiple_id_category'] = $controllerCategory->getList();

        foreach($this->construct['content_multiple_id_category'] as &$item){
            $this->setIdCategory($item['id_category']);
            $this->setIdWork($id);
            $item['selected'] = false;
            if($this->categorySelected()){
                $item['selected'] = true;
            }
        }
    }

    public function actions($action)
    {
        if($action == 'update'){

            $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $this->construct['id_table'])));
            $this->$var($_POST[$this->construct['id_table']]);

            foreach($this->construct['fields'] as $key => $field){
                if(isset($field['update']) && $field['update']){
                    $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $key)));
                    $this->$var($_POST[$key]);
                }
            }

            //$this->update();

            if(isset($this->construct['fields_lang']) && $this->construct['fields_lang']){
                $languages = $this->getLanguages();
                foreach($languages as $language){
                    $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $this->construct['id_table'])));
                    $this->$var($_POST[$this->construct['id_table']]);

                    $id_language = $language['id_language'];
                    $this->setIdLanguage($id_language);

                    foreach($this->construct['fields_lang'] as $key => $field){
                        if(isset($field['update']) && $field['update'] && $key != $this->construct['id_table']){
                            $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $key)));
                            $this->$var($_POST[$key][$id_language]);
                        }
                    }

                    $this->update();

                }
            }

            if(isset($_POST['id_category']) && $_POST['id_category']){
                $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $this->construct['id_table'])));
                $this->$var($_POST[$this->construct['id_table']]);
                $this->deleteCategories();

                foreach($_POST['id_category'] as $category){

                    $this->setIdCategory($category);
                    $this->insertCategories();
                }
            }


        }else if($action == 'add'){

            $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $this->construct['id_table'])));
            $this->$var($_POST[$this->construct['id_table']]);

            foreach($this->construct['fields'] as $key => $field){
                if(isset($field['update']) && $field['update']){
                    $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $key)));
                    $this->$var($_POST[$key]);
                }
            }

            $id_table = $this->insert();

            if(isset($this->construct['fields_lang']) && $this->construct['fields_lang']){
                $languages = $this->getLanguages();
                foreach($languages as $language){
                    $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $this->construct['id_table'])));
                    $this->$var($id_table);

                    $id_language = $language['id_language'];
                    $this->setIdLanguage($id_language);

                    foreach($this->construct['fields_lang'] as $key => $field){
                        if(isset($field['update']) && $field['update'] && $key != $this->construct['id_table']){
                            $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $key)));
                            $this->$var($_POST[$key][$id_language]);
                        }
                    }

                    $this->insertLang();

                }
            }

            if(isset($_POST['id_category[]']) && $_POST['id_category[]']){
                $var = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $this->construct['id_table'])));
                $this->$var($_POST[$this->construct['id_table']]);
                foreach($_POST['id_category[]'] as $category){
                    $this->setIdCategory($category);
                    $this->insertCategories();
                }
            }

            header('Location: ' . URL_SITE . '/admin/form/' . $_GET['class'] . '/' . $id_table);

        }else if($action == 'delete'){
            header('Location: ' . URL_SITE . '/admin/list/' . $_GET['class'] . '/');
        }
    }

}
<?php

// todo: split various versions & document encoding

class HtmlView extends View {

    protected $_title = "";

    public function setTitle($title = "") {
        $this->_title = $title;
    }

    public function getDocumentDeclaration() {
        $str  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL;
        $str .= "<!DOCTYPE html".PHP_EOL;
        $str .= "    PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN".PHP_EOL;
        $str .= "    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">".PHP_EOL;
        $str .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">".PHP_EOL;
        return $str;
    }



    public function render(array $data = null) {

        if(is_array($data)) {
            foreach($data as $key => $value) {
                if(is_array($value))
                    $this->$key = array_map('htmlentities', $value);
                else
                    $this->$key = htmlentities($value);
            }
        }

        $this->view = $this;

        //var_dump($data);

        unset($data);

        // todo: to view items


        $snips = array();

        foreach($this->_file as $key => $snippet) {
            ob_start();
            require_once($snippet);
            $this->$key = ob_get_clean();
        }



        //var_dump($snips);


        ob_start();

        if($this->_template != null)
            require_once($this->_template);

        $this->_view = ob_get_clean();


        //echo "<hr />".$data."<hr />";


        return $this->_view;
    }
}
 

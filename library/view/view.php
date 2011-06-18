<?php

class View {
    public function Render(){}

    public $documentType;

    protected $_content;
    protected $_view;
    protected $_module;
    protected $_file;
    protected $_template;

    public function __construct($module) {
        $this->_module = $module;
    }

    public function load($file, $name) {
        $this->_file[$name] = ROOT.DS.'application'.DS.$this->_module.DS.'view'.DS.$file.'.php';
        if(!file_exists($this->_file[$name]))
            throw new Exception("The view '$name' could not found");
    }

    public function loadTemplate($template) {
        $this->_template = ROOT.DS.'templates'.DS.$template.'.php';
        if(!file_exists($this->_template))
            throw new Exception("The view '$this->_template' could not found");
    }

}

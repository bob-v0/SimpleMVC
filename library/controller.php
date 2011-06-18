<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vdm
 * Date: 6/4/11
 * Time: 5:09 PM
 * To change this template use File | Settings | File Templates.
 */


class Controller {

    public $view;

    public function __construct($module = null) {
        $this->_module = $module;

        // Default renderer
        $this->view = new HtmlView(lcfirst($module));
    }

}


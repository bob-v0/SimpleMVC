<?php
/**
 * {file description}
 *
 * @package    {package}
 * @module     {module}
 * @author     vdm, $Author:$
 * @date       6/4/11
 * @time       3:03 PM
 * @licence    {license}
 * @copyright  {copy}, {url}
 * @version    $Id:$
 */

class ServicesController extends Controller
{

    function indexAction()
    {
        $this->view->loadTemplate("main");
        $this->view->load('services_index', 'content');
        return $this->view->render();
    }
}
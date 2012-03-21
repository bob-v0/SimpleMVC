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

class SupportController extends Controller
{

    function indexAction()
    {
        $this->view->loadTemplate("main");
        $this->view->load('support_index', 'content');
        return $this->view->render();
    }
}
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

class IndexController extends Controller
{

    function indexAction()
    {
        $this->view->loadTemplate("main");
        $this->view->load('index_index', 'content');
        return $this->view->render();
    }


    function testAction($query)
    {
        $mail = new Smtp("localhost", 25, "", "");
        $mail->Send(
            array("email"=>"dutchpowercow@gmail.com", "name"=>"bob"),
            array(array("email" => "dutchpowercow@gmail.com", "bob2")),
            "test subj",
            "wheeej"
        );

        $data = array('title' => 'a title', 'log' => $mail->getLog());

        $this->view->loadTemplate("main");
        $this->view->load('index_test', 'content');
        return $this->view->render($data);
    }

    function xmlAction($query)
    {
        header ("Content-Type:text/xml");
        ob_start();
        echo "<document>";
        echo "<element attribute=\"a\" />";
        echo "<element attribute=\"b\" />";
        echo "<element attribute=\"c\" />";
        echo "</document>";
        return ob_get_clean();
    }

    function someAction()
    {
        echo "test";
    }
}
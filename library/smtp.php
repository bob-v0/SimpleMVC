<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vdm
 * Date: 6/9/11
 * Time: 8:51 PM
 * To change this template use File | Settings | File Templates.
 */


class Smtp {

    protected $_host;
    protected $_port;
    protected $_user;
    protected $_pass;
    protected $_socket;
    protected $_timeout;
    protected $_log = array();

    public function getLog() {
        return $this->_log;
    }

    public function __construct($host, $port, $user, $password)
    {
        $this->_host = $host;
        $this->_port = $port;
        $this->_user = $user;
        $this->_pass = $password;
    }

    public function Send(array $from, array $to, $subject, $body)
    {
        $this->_socket = @fsockopen($this->_host, $this->_port, $erstr, $erli, $this->_timeout);
        if(empty($this->_socket)) {
            $this->_log[] = sprintf("Could not connect to %s:%s.", $this->_host, $this->_port);
            return;
        }

        $this->_log[] = fprintf("Connected to %s:%s", $this->_host, $this->_port);

        fputs($this->_socket, "AUTH LOGIN\r\n");
        $this->_log[] = fgets($this->_socket, 515);
        fputs($this->_socket, base64_encode($this->_user)."\r\n");
        $this->_log[] = fgets($this->_socket, 515);
        fputs($this->_socket, base64_encode($this->_pass)."\r\n");
        $this->_log[] = fgets($this->_socket, 515);

        fputs($this->_socket, "HELO localhost\r\n");
        $this->_log[] = fgets($this->_socket, 515);


        fputs($this->_socket, "MAIL FROM: ".$from["email"]."\r\n");
        $this->_log[] = fgets($this->_socket, 515);

        foreach($to as $key => $value) {
            fputs($this->_socket, "RCPT TO: ".$value["email"]."\r\n");
            $this->_log[] = fgets($this->_socket, 515);
        }

        fputs($this->_socket, "DATA\r\n");
        $this->_log[] = fgets($this->_socket, 515);

        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; carset=iso-8859\r\n";

        foreach($to as $key => $value) {
            $header .= "To: ".$value["email"]."\r\n";
        }
        $header .= "From: ".$from["name"]."\r\n";
        $header .= "Subject: $subject\r\n";
        fputs($this->_socket, "$header\n\n$body\r\n.\r\n");
        $this->_log[] = fgets($this->_socket, 515);

        fputs($this->_socket, "QUIT\r\n");
        $this->_log = fgets($this->_socket, 515);

        if(!empty($this->_socket))
            fclose($this->_socket);

    }

}

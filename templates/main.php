<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title><?php echo @$this->title; ?></title>
    <link href="<?php echo BASE_URL; ?>/css/main.css" media="screen" type="text/css" rel="stylesheet" />
    <script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo BASE_URL; ?>/js/main.js"></script>
</head>

<body>
<div class="border_outer">
    <div id="logo"><img alt="btn" src="<?php echo BASE_URL; ?>/img/logo.png" /></div>
    <div style="float: right; padding-top: 5px; padding-right: 5px;"><img alt="btn" src="<?php echo BASE_URL; ?>/img/button02.png" />&nbsp;<img alt="btn" src="<?php echo BASE_URL; ?>/img/button02.png" />&nbsp;<img alt="btn" src="<?php echo BASE_URL; ?>/img/button02.png" /></div>
    <div style="clear:both;"></div>

    <div class="buttonbar">
        <style>
            .aa { float: left; width: 80px; color: #2e89e4; height: 45px; text-align: center; border: 0px solid black; border-right: 0px; margin-top: 2px; margin-bottom: 2px; }
            .aa_last {
                border-right: solid 0px black;
            }
            .aa p {padding-top: 14px;}
            .aa a {color: #2e89e4; text-decoration: none;}
            .ab {float: right; padding-top: 15px;}
        </style>
        <div class="aa"><p><a href="">Home</a></p></div> <div class="aa"><p><a href="">Services</a></p></div> <div class="aa"><p><a href="">Support</a></p></div> <div class="aa aa_last"><p><a href="">Contact</a></p></div>
        <div class="ab">
            <form><input id="search_text" type="text" value="search site" /> <input type="button" value="search" /></form>
        </div>
        <div style="clear:both;"></div>
    </div>

    <div class="page">
        <div class="breadcrumb" style="float: left"><a href="<?php echo BASE_URL; ?>">Home</a><img src="<?php echo BASE_URL; ?>/img/arrow.png" alt="arrow"> <a href="#">Category</a> <img src="<?php echo BASE_URL; ?>/img/arrow.png" alt="arrow"> <a href="#">Controller</a> <img src="<?php echo BASE_URL; ?>/img/arrow.png" alt="arrow"> <a href="#">Action</a></div>
        <div class="wrapper_login"><form><input id="login_username" type="text" value="username" name="login_username"> <input id="login_password" type="text" value="password"> <input type="button" value="login"></form></div>
        <div style="clear: both;"></div>
        <hr />

        <?php echo @$this->content; ?>

    </div>


</div>

<div class='bottom_wrapper2'>
    <div class='bottom_wrapper'>
        <table class="bottom_listing">
            <tr><td style="width: 50px;"></td>
                <td>
                    <ul>
                        <li><a href="#">interdum non</a></li>
                        <li><a href="#">Quisque vitae</a></li>
                        <li><a href="#">interdum Vivamus</a></li>
                        <li><a href="#">aliquam non</a></li>
                        <li><a href="#">placerat</a></li>
                    </ul>
                </td>
                <td style="width: 100px;"></td>
                <td>
                    <ul>
                        <li><a href="#">Etiam sed</a></li>
                        <li><a href="#">Quisque vitae leo</a></li>
                        <li><a href="#">Integer eget</a></li>
                        <li><a href="#">Vitae leo ut augue</a></li>
                        <li><a href="#">Aenean porta auctor</a></li>
                    </ul>
                </td>
                <td style="width: 100px;"></td>
                <td>
                    <ul>
                        <li><a href="#">felis blandit facilisis</a></li>
                        <li><a href="#">felis blandit facilisis</a></li>
                        <li><a href="#">felis blandit facilisis</a></li>
                        <li><a href="#">felis blandit facilisis</a></li>
                        <li><a href="#">felis blandit facilisis</a></li>
                    </ul>
                </td>
            </tr>

        </table>
    </div>
    <div class="copy">
        Copyright 2011 by Custom-Design &copy;<br />
        For website related matter you can contact us at contact (at) domain dot tld<br />
    </div>
</div>


</body>
</html>
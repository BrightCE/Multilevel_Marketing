<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//Add all program functions
include 'dbfunctions.php';
include 'validatefunctions.php';
include 'outputfunctions.php';

function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}
?>

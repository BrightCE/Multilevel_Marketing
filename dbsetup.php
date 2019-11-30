<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function dbconnect()
    {
        @ $db = new mysqli('localhost', 'root', '1981bce');

        if (mysqli_connect_error())
            {
                die('Could not connect: ' . mysqli_connect_error());
            }

        return $db;
    }
function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br />";
}

function queryMysql($query)
{
    $conn = dbconnect();
    $result = $conn->query($query) or die (mysqli_error($conn));
	 return $result;
}

$create_db = "create database mlm";
$result = queryMysql($create_db);
echo "$result <br>";
$grant_q = "grant all on mlm.* to 'mlmapp'@'localhost' identified by 'mlmpswd'";
$result2 = queryMysql($grant_q);
echo $result2;


?>

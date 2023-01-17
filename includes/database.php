<?php 

$db_host="localhost";
$db_name="artykuly_portfolio";
$db_user="AgataDF";
$db_password="yL8MMllcmNO6bMfN";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if(mysqli_connect_error()){
    echo mysqli_connect_error();
    exit;
}
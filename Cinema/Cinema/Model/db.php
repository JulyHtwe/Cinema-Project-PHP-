<?php
$connection=new mysqli("localhost","root","","cinemadb");
if($connection->connect_error){
    die("Connection filed".$connection->connect_error);
}

?>
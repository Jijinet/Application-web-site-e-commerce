<?php

//? Connexion

$servername="localhost:3306";
$username="root";
$password="root";
$dbname="boutique";

$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);

?>
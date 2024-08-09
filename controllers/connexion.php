<?php

//? Connexion

$servername="localhost:3306";
$username="root";
<<<<<<< HEAD
$password="";
=======
$password="root";
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
$dbname="boutique";

$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);

?>
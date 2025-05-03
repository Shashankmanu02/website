<?php

$dsn = 'mysql:host=localhost;dbname=FashionCart';
$username = 'root';
$password = '';
try{
$connection = new PDO($dsn, $username, $password);
}

catch(PDOException $e){
    echo "<script type='text/javascript'>alert('Failed to Establish Connection. Contact Admin: shashankmanu02@gmail.com');window.location.href='error.php';</script>";
}

?>
<?php

$database="intelcost_bienes";
$user='root';
$password='';


try {

$con=new PDO('mysql:host=localhost;dbname='.$database,$user,$password);

} catch (PDOException $e) {
echo "Error".$e->getMessage();
}


$conexion = mysqli_connect("localhost", "root", "", "intelcost_bienes");

?>

<?php
$serverusername ="localhost";
$username = "root";
$password = "";
$dbname = "pet_data";

$conn = new mysqli($serverusername,$username,$password,$dbname);

if($conn->connect_error){
    die("gagal". $conn->connect_error);
}

?>
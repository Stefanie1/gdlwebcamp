<?php
    $conn= new mysqli('localhost','root','Morita123','gdlwebcamp1'); //direccion de la base 

    if($conn->connect_error){
        echo $error ->$conn->connect_error;
    }
?>
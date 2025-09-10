<?php

$localhost = "";
$username = "root";
$password = "";
$database = "BudgetLancer";

$conex = new mysqli($localhost, $username, $password, $database);

if ($conex->connect_error){
    echo "Falha na conexão";
}

echo "Conexão bem sucedida!";

$conex->close();
?>
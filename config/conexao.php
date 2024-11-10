<?php
$server = "localhost";
$user = "root";
$pass = "";
$bd = "cadastro_tarefas";

if ($conn = mysqli_connect($server, $user, $pass, $bd)) {
    // echo "Conetado!";
} else
    echo "Erro na conexão!";

?>
<?php

include 'conexao.php';

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_usuario = "DELETE FROM tarefas WHERE id_tarefa='$id'";
    $mysqli_query = mysqli_query($conn, $result_usuario);

    if (mysqli_affected_rows($conn)) {

        header("Location: ../index.php#sessao-lista");
        exit(); 

    }
}else{
    $_SESSION['msg'] = "<p style='color:green;'> Selcione um usuario</p>";
}


?>


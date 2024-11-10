<?php
include 'conexao.php';

$cad_id_item = $_POST["cad_id_item"];


$arr_item = explode(",", $cad_id_item);


$ordem = 1;

foreach ($arr_item as $arr_item) {

    $sql = "UPDATE tarefas SET ordem = $ordem WHERE id_tarefa = $arr_item";

    $execute = $conn->query($sql) or die(mysqli_error($conn));

    $ordem++;

}


?>
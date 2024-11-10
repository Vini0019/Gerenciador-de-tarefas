<?php
include 'conexao.php';


if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM tarefas WHERE nome LIKE '%$data%' ORDER BY ordem ASC";
} else {
    
    $sql = "SELECT id_tarefa, nome, custo, data_limite, ordem FROM tarefas ORDER BY ordem ASC";
}

$dados = mysqli_query($conn, $sql);

// formatar a data
function mostra_data($data) {
    $d = explode('-', $data);
    $escreve = $d[2] . "/" . $d[1] . "/" . $d[0];
    return $escreve;
}
?>

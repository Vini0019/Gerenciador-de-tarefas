<?php
function editarTarefa($conn, $id, $nome, $custo, $data)
{
    
    $nome = mysqli_real_escape_string($conn, $nome);
    $custo = mysqli_real_escape_string($conn, $custo);
    $data = mysqli_real_escape_string($conn, $data);

    // Query para atualizar a tarefa
    $sql = "UPDATE tarefas SET nome = '$nome', custo = '$custo', data_limite = '$data' WHERE id_tarefa = '$id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensagem_sucesso'] = "Tarefa '$nome' atualizada com sucesso!";
        header("Location: ../index.php#sessao-lista");

        return true;
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao atualizar '$nome': " . mysqli_error($conn);
        return false;
    }
}
?>

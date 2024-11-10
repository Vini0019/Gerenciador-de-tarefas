<?php
function adicionarTarefa($conn, $nome, $custo, $data)
{

    // para verificar se o nome já existe
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tarefas WHERE nome = '$nome'");
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        $_SESSION['mensagem_erro'] = "Erro: A tarefa '$nome' já existe. Escolha outro nome.";
    } else {
        // fazendo um incremento da coluna de ordem
        $result = mysqli_query($conn, "SELECT COALESCE(MAX(ordem), -1) AS max_ordem FROM tarefas");
        $nova_ordem = mysqli_fetch_assoc($result)['max_ordem'] + 1;


        if (mysqli_query($conn, "INSERT INTO tarefas (nome, custo, data_limite, ordem) VALUES ('$nome', '$custo', '$data', $nova_ordem)")) {
            $_SESSION['mensagem_sucesso'] = "Tarefa '$nome' cadastrada com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar '$nome': " . mysqli_error($conn);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "#sessao-lista");
    exit(); 
}
?>
<?php
include "config/conexao.php";
include "config/cadastro.php";
include "config/buscaDados.php";
include "config/editarDados.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Dados para edição
        $id = $_POST['id_tarefa'];
        $nome = $_POST['nome-tarefa'];
        $custo = $_POST['custo-tarefa'];
        $data = $_POST['data-tarefa'];

        // Chama a função para editar a tarefa
        $resultado = editarTarefa($conn, $id, $nome, $custo, $data);

    } else {
        // Dados para adição de nova tarefa
        $nome = $_POST['nome-tarefa'];
        $custo = $_POST['custo-tarefa'];
        $data = $_POST['data-tarefa'];

        // Chama a função para adicionar a tarefa
        $resultado = adicionarTarefa($conn, $nome, $custo, $data);
    }

    if ($resultado === true) {
        // Redireciona para evitar reenvio do formulário
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo $resultado;
    }
}

// Exibe a mensagem de sucesso e de erro em um pop up
if (isset($_SESSION['mensagem_sucesso'])) {
    echo "  <div class='alert-cadastro'>
            <div class='alert-content'>
                <div class='icone-cadastro'>
                    <img src='assets/icons/sucesso-icon.png' alt=''>
                </div>
                <span class='close-btn' id='close-btn-sucesso'>&times;</span>
                <div class='paragrafo-mensagem'>
                    <h2>Sucesso!</h2>
                    <p>Tarefa cadastrada com sucesso! </p>
                </div>
            </div>
        </div>";
    unset($_SESSION['mensagem_sucesso']);
} elseif (isset($_SESSION['mensagem_erro'])) {
    echo "  <div class='alert-cadastro erro' id='alert-cadastro-erro'>
            <div class='alert-content'>
                <div class='icone-cadastro erro'>
                    <img src='assets/icons/erro-icon.png' alt=''>
                </div>
                <span class='close-btn' id='close-btn-erro'>&times;</span>
                <div class='paragrafo-mensagem'>
                    <h2>Erro!</h2>
                    <p>A tarefa já existe. Por favor, escolha outro nome.</p>
                </div>
            </div>
        </div>";
    unset($_SESSION['mensagem_erro']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <title>Lista de tarefas</title>
    <script src="https://unpkg.com/scrollreveal"></script>
</head>

<body>


    <!-- Pop-up para adicionar tarefas -->
    <dialog class="modal" id="modal-criar">
        <div class="close-btn close-btn">&times;</div>
        <form method="POST" class="formulario">
            <h2>Adicionar tarefa</h2>
            <div class="form-adicionar-tarefa">
                <label for="nome-tarefa">Nome da Tarefa</label>
                <input type="text" name="nome-tarefa" id="nome-tarefa" placeholder="Adicione o nome" required>
            </div>
            <div class="form-adicionar-tarefa">
                <label for="custo">Custo</label>
                <input type="number" name="custo-tarefa" id="custo-tarefa" placeholder="Adicione o custo" min="0"
                    required>
            </div>
            <div class="form-adicionar-tarefa">
                <label for="data-tarefa">Data Limite</label>
                <input type="date" name="data-tarefa" id="data-tarefa" placeholder="Adicione uma data" required min="<?php date_default_timezone_set('America/Sao_Paulo');
                echo date('Y-m-d'); ?>">
            </div>
            <div class="form-adicionar-tarefa">
                <button type="submit">Adicionar</button>
            </div>
        </form>
    </dialog>

    <!-- pop up para editar Tarefa -->
    <dialog class="modal modal-editar" id="modal-editar">
        <div class="close-btn close-btn-editar">&times;</div>
        <form method="POST" class="formulario">
            <h2>Editar tarefa</h2>

            <!-- Campo oculto para armazenar o ID da tarefa -->
            <input type="hidden" name="id_tarefa" id="id-tarefa-editar">

            <div class="form-adicionar-tarefa">
                <label for="nome-tarefa">Nome da Tarefa</label>
                <input type="text" name="nome-tarefa" id="nome-tarefa-editar" placeholder="Adicione o nome" required>
            </div>
            <div class="form-adicionar-tarefa">
                <label for="custo">Custo</label>
                <input type="text" name="custo-tarefa" id="custo-tarefa-editar" placeholder="Adicione o custo" required>
            </div>
            <div class="form-adicionar-tarefa">
                <label for="data-tarefa">Data Limite</label>
                <input type="date" name="data-tarefa" id="data-tarefa-editar" placeholder="Adicione uma data" required
                    min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-adicionar-tarefa">
                <button type="submit" name="editar">Editar</button>
            </div>
        </form>
    </dialog>

    <section class="sessao-intro">
        <div class="circle"></div>
        <header>
            <a href="#"><img src="assets/icons/logo.png" alt="" class="logo"></a>
        </header>
        <div class="content">
            <div class="text efeito-txt-topo">
                <h2>A LISTA DE TAREFAS <br>QUE VOCÊ PRECISA</h2>
                <p>O Gerenciador de Tarefas da Fatto Consultoria foi criado para otimizar sua produtividade e
                    simplificar a gestão diária. Com nossa experiência e dedicação, tornamos a organização das suas
                    tarefas mais eficiente e prática.</p>
                <div class="btn-lista">
                    <a href="#sessao-lista">CONHEÇA NOSSO GERENCIADOR <img src="assets/icons/seta.png"></a>
                </div>
            </div>
        </div>
        <div class="boxImg">
            <img src="assets/icons/lista.png" alt="" class="img1 efeito-img-topo-1">
            <img src="assets/icons/adiciona.png" alt="" class="img2 efeito-img-topo-2">
            <img src="assets/icons/editar.png" alt="" class="img3 efeito-img-topo-3">
        </div>
    </section>


    <div class="overlay"></div>

    <section class="sessao-lista" id="sessao-lista">


        <div class="container-tabela">

            <div class="titulo-lista efeito-txt-topo">
                <h1>Tarefas</h1>
            </div>


            <div class="container-pesquisa-tarefa">

                <div class="icon-pesquisa-tarefa">
                    <input type="text" name="pesquisa" id="pesquisa-tarefa" placeholder="Pesquise uma tarefa">
                    <button class="btn-pesquisa" onclick="searchData()"><img
                            src="assets/icons/pesquisa-icon.png"></button>
                </div>

                <button class="nova-tarefa" id="btn-nova-tarefa">Nova tarefa</button>
            </div>

            <!-- Criação da tabela de lista de tarefas -->
            <table class="tabela-tarefas">
                <thead>
                    <tr>
                        <th>
                            ID Tarefa
                        </th>

                        <th>
                            Nome da tarefa
                        </th>

                        <th>
                            Custo (R$)
                        </th>
                        <th>
                            Data limite
                        </th>
                        <th>Editar</th> <!--Coluna do botão Incluir -->
                        <th>Excluir</th> <!--Coluna do botão Excluir -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($dados) > 0) {
                        while ($linha = mysqli_fetch_assoc($dados)) {
                            $id = $linha['id_tarefa'];
                            $nome = $linha['nome'];
                            $custo = $linha['custo'];
                            $data = $linha['data_limite'];
                            $data = mostra_data($data);
                            $ordem = $linha['ordem'];

                            $linhaClasse = $custo > 1000 ? 'linha-alta' : 'linha-normal';

                            echo
                                "<tr id='$id' class='$linhaClasse'>
                                <td>
                                    $id
                                </td>
                                <td>
                                    $nome
                                </td>
                                <td>
                                    $custo
                                </td>
                                <td>
                                    $data
                                </td>
                                <td class='icon icon-editar' data-id='$id' data-nome='$nome' data-custo=' $custo' data-data='$data'>
                                    <svg class='feather feather-edit' fill='none' height='24' stroke='currentColor'
                                        stroke-linecap='round' stroke-linejoin='round' stroke-width='2' viewBox='0 0 24 24'
                                        width='25' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7' />
                                        <path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z' />
                                    </svg>
                                </td>
                                <td class='icon excluir' id='icon-excluir'>
                                    
                                    <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='25' height='25'
                                        text-align='right' viewBox='0 0 30 30' onclick='pegar_dados($id)'>
                                        <path
                                            d='M 14.984375 2.4863281 A 1.0001 1.0001 0 0 0 14 3.5 L 14 4 L 8.5 4 A 1.0001 1.0001 0 0 0 7.4863281 5 L 6 5 A 1.0001 1.0001 0 1 0 6 7 L 24 7 A 1.0001 1.0001 0 1 0 24 5 L 22.513672 5 A 1.0001 1.0001 0 0 0 21.5 4 L 16 4 L 16 3.5 A 1.0001 1.0001 0 0 0 14.984375 2.4863281 z M 6 9 L 7.7929688 24.234375 C 7.9109687 25.241375 8.7633438 26 9.7773438 26 L 20.222656 26 C 21.236656 26 22.088031 25.241375 22.207031 24.234375 L 24 9 L 6 9 z'>
                                        </path>
                                    </svg>
                                    
                                </td>
                            </tr>";

                        }
                    } else {
                        echo "<tr><td colspan='6'>Adicione uma tarefa</td></tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <div class="container-footer">
            <div class="footer-conteudo">
                <h3>Contato</h3>
                <span class="linha"></span>
                <p>Email: vinimkb44@gmail.com</p>
                <p>Contato: (81) 98574-7957</p>
            </div>
            <div class="footer-conteudo">
                <h3>Redes sociais</h3>
                <span class="linha titulo-rede"></span>
                <ul class="footer-icones">
                    <li><a href="https://github.com/Vini0019" target="_blank"><img src="assets/icons/github-icon.png" alt=""></a></li>
                    <li><a href="https://www.linkedin.com/in/vinicius-santos-a66367163/" target="_blank"><img src="assets/icons/linkedin-icon.png" alt=""></a></li>
                </ul>
            </div>
        </div>
    </footer>


    <!-- Pop-up com fundo e conteúdo -->
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-content">
            <h2>Confirmação</h2>
            <form action="config/deletarDados.php" method="POST">
                <p>Você realmente deseja realizar esta ação?</p>
                <div class="popup-buttons">

                    <input type="submit" class="confirm-btn" value="confirmar">

                    <input type="" name="id" id="cod_tarefa" value="" hidden>
            </form>

            <button type="button" class="cancel-btn" onclick="closePopup()">Cancelar</button>

        </div>

    </div>

</body>
<script src="assets/scripts/script.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Inclua o jQuery UI (necessário para sortable) -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function () {
        $(".tabela-tarefas tbody").sortable({
            placeholder: 'dragHelper',
            cursor: "move",

            update: function (event, ui) {
                var cad_id_item_list = $(this).sortable('toArray').toString();

                // alert(cad_id_item_list);

                $.ajax({
                    url: 'config/cad_ordenar_item.php',
                    type: 'POST',
                    data: { cad_id_item: cad_id_item_list },
                    success: function (data) {
                        console.log("Ordem salva com sucesso:", data);

                    },
                    error: function (xhr, status, error) {
                        console.log("Erro na requisição AJAX:", error);
                    }
                });
            }
        });
    });
</script>

</html>
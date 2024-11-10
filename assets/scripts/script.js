const botao = document.querySelector("#btn-nova-tarefa");
const modal = document.querySelector(".modal");

const closebtn = document.querySelector(".close-btn");
const overlay = document.querySelector(".overlay");

const alert_sucesso = document.querySelector(".alert-cadastro");
const closebtn_sucesso = document.querySelector("#close-btn-sucesso");

const closebtn_erro = document.querySelector("#close-btn-erro");

const modal_editar = document.querySelector(".modal-editar");
const icon_fechar_editar = document.querySelector(".close-btn-editar");
const icons_editar = document.querySelectorAll(".icon-editar");

const modal_excluir = document.querySelector("#modal-excluir");
const icon_excluir = document.querySelector("#icon-excluir");

// Função para abrir um modal específico
function abrirModal(modal) {
    modal.showModal();
    overlay.classList.add("ativo");
}

// Função para fechar um modal específico
function fecharModal(modal) {
    overlay.classList.remove("ativo");
    modal.close();
}

// Função para fechar alertas
function fecharAlerta(alerta) {
    alerta.style.display = 'none';
}

// Função para fechar alertas
function abrirAlerta(alerta) {
    alerta.style.display = 'block';
}


botao.onclick = () => abrirModal(modal); // abre o modal para nova tarefa
closebtn.onclick = () => fecharModal(modal); // fecha o modal para nova tarefa

icon_excluir.onclick = () => abrirAlerta(modal_excluir);


// abrir pop up e preencher todas tarefas
icons_editar.forEach(icon => {
    icon.onclick = () => {
        const id = icon.getAttribute("data-id");
        const nome = icon.getAttribute("data-nome");
        const custo = icon.getAttribute("data-custo");
        const data = icon.getAttribute("data-data");

        modal_editar.querySelector("input[name='nome-tarefa']").value = nome;
        modal_editar.querySelector("input[name='custo-tarefa']").value = custo;
        modal_editar.querySelector("input[name='data-tarefa']").value = data;

        abrirModal(modal_editar);
    };
});

icon_fechar_editar.onclick = () => fecharModal(modal_editar); // Fecha o modal para editar tarefa

// fecha alerta
document.addEventListener("click", event => {
    fecharAlerta(alert_sucesso);
    fecharAlerta(alert_erro);
});

document.querySelectorAll('.icon-editar').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const nome = this.getAttribute('data-nome');
        const custo = this.getAttribute('data-custo');
        const data = this.getAttribute('data-data');

        // Preenche os campos do formulário de edição
        document.getElementById('id-tarefa-editar').value = id;
        document.getElementById('nome-tarefa-editar').value = nome;
        document.getElementById('custo-tarefa-editar').value = custo;
        document.getElementById('data-tarefa-editar').value = data;

        // Exibe a modal de edição
        document.getElementById('modal-editar').showModal();
    });
});

// Função para abrir o pop-up
function openPopup() {
    document.getElementById("popupOverlay").style.display = "flex";
}

// Função para fechar o pop-up
function closePopup() {
    document.getElementById("popupOverlay").style.display = "none";
}

function pegar_dados(id) {
    document.getElementById("popupOverlay").style.display = "flex";

    document.getElementById('cod_tarefa').value = id;

}

var pesquisa = document.getElementById('pesquisa-tarefa');

pesquisa.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        searchData();
    }
});

function searchData() {
    window.location = 'index.php?search=' + pesquisa.value + '#sessao-lista';
}

document.addEventListener("DOMContentLoaded", function() {
    ScrollReveal().reveal('.tabela-tarefas', { delay: 200, duration: 1000 });
});


// criando efeito de reveal
window.revelar = ScrollReveal({reset:true});

revelar.reveal('.efeito-txt-topo',{
    duration: 2000,
    distance: '90px'
})

revelar.reveal('.efeito-img-topo-1',{
    duration: 2000,
    distance: '90px',
    delay: 500
})

revelar.reveal('.efeito-img-topo-2',{
    duration: 2000,
    distance: '90px',
    delay: 700

})

revelar.reveal('.efeito-img-topo-3',{
    duration: 2000,
    distance: '90px',
    delay: 900

})


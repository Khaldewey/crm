<?php
// app/controllers/contatosController.php

require_once '../../../app/models/Contato.php';

class ContatosController {
    public function index() {
        $contatos = array();

        try {
            global $pdo;

            $stmt = $pdo->query("SELECT * FROM contatos");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                // Crie instâncias da classe Contato para cada registro do banco de dados
                $contato = new Contato();
                $contato->setConId($row['con_id']);
                $contato->setConNome($row['con_nome']);
                $contato->setConTelefone($row['con_telefone']);
                $contato->setConCpf($row['con_cpf']);
                $contato->setBreId($row['bre_id']);
                $contato->setBroId($row['bro_id']);

                // Adicione o objeto Contato ao array
                $contatos[] = $contato;
            }

        } catch (PDOException $e) {
            echo "Erro ao obter contatos: " . $e->getMessage();
        }

        return $contatos;
    }

    public function cadastrar() {
        // Função para exibir o formulário de cadastro
        $informacoesCidadeEstado = Contato::obterInformacoesCidadeEstado();
        include '../../views/contatos/cadastrar.php';
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica se os campos obrigatórios foram preenchidos
            if (!empty($_POST['con_nome']) && !empty($_POST['con_telefone']) && !empty($_POST['con_cpf']) && !empty($_POST['bre_id']) && !empty($_POST['bro_id'])) {
                // Cria um novo objeto Contato
                $contato = new Contato();
    
                // Preenche as propriedades do objeto $contato com os dados do formulário
                $contato->setConNome($_POST['con_nome']);
                $contato->setConTelefone($_POST['con_telefone']);
                $contato->setConCpf($_POST['con_cpf']);
                $contato->setBreId($_POST['bre_id']);
                $contato->setBroId($_POST['bro_id']);
    
                // Chama o método salvarContato()
                $contato->salvarContato();
    
                // Redireciona para a página principal
                header('Location: index.php');
            } else {
                echo "Todos os campos são obrigatórios. Preencha todos os campos e tente novamente.";
            }
        }
        // Função para processar o formulário de cadastro
        // e salvar um novo contato no banco de dados
        // $contato = new Contato();
        // Preencha as propriedades do objeto $contato com os dados do formulário
        // $contato->salvarContato();
        // header('Location: index.php');
    }

    public function editar($con_id) {
        // Função para exibir o formulário de edição
        // com os dados do contato que será editado
        $contato = Contato::obterContatoPorId($con_id);
        $informacoesCidadeEstado = Contato::obterInformacoesCidadeEstado();
        include '../../views/contatos/editar.php';
    }

    public function atualizar() {
        // Verifique se todos os dados necessários estão disponíveis no $_POST
        $con_id = $_GET['con_id'];
        $con_nome = $_POST['con_nome'];
        $con_telefone = $_POST['con_telefone'];
        $con_cpf = $_POST['con_cpf'];
        $bre_id = $_POST['bre_id'];
        $bro_id = $_POST['bro_id'];
    
        // Função para processar o formulário de edição
        // e atualizar as informações do contato no banco de dados
        $contato = new Contato();
        // Preencha as propriedades do objeto $contato com os dados do formulário
        $contato->atualizarContato($con_id, $con_nome, $con_telefone, $con_cpf, $bre_id, $bro_id);
        header('Location: index.php');
    }

    public function excluir($con_id) {
        // Função para excluir um contato do banco de dados
        Contato::excluirContato($con_id);
        header('Location: index.php');
    }
}
//rotas 

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$contatosController = new ContatosController();

if ($action == 'index') {
    $contatosController->index();
} elseif ($action == 'cadastrar') {
    $contatosController->cadastrar();
} elseif ($action == 'salvar') {
    $contatosController->salvar();
} elseif ($action == 'editar') {
    $contatosController->editar($_GET['con_id']);
} elseif ($action == 'atualizar') {
    $contatosController->atualizar();
} elseif ($action == 'excluir') {
    $contatosController->excluir($_GET['con_id']);
}
?>

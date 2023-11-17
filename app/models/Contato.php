<?php
require_once '../../../app/config/database.php';
class Contato {
    private $con_id;
    private $con_nome;
    private $con_telefone;
    private $con_cpf;
    private $bre_id; // cidade id
    private $bro_id; // estado id

    // Métodos getter e setter para cada propriedade
    public function getConId() {
        return $this->con_id;
    }

    public function setConId($con_id) {
        $this->con_id = $con_id;
    }

    public function getConNome() {
        return $this->con_nome;
    }

    public function setConNome($con_nome) {
        $this->con_nome = $con_nome;
    }

    public function getConTelefone() {
        return $this->con_telefone;
    }

    public function setConTelefone($con_telefone) {
        $this->con_telefone = $con_telefone;
    }

    public function getConCpf() {
        return $this->con_cpf;
    }

    public function setConCpf($con_cpf) {
        $this->con_cpf = $con_cpf;
    }

    public function getBreId() {
        return $this->bre_id;
    }

    public function setBreId($bre_id) {
        $this->bre_id = $bre_id;
    }

    public function getBroId() {
        return $this->bro_id;
    }

    public function setBroId($bro_id) {
        $this->bro_id = $bro_id;
    } 

    public function getBreNome() {
        try {
            global $pdo;

            $stmt = $pdo->prepare("SELECT bre_nome FROM brasil_cidades WHERE bre_id = :bre_id");
            $stmt->bindParam(':bre_id', $this->bre_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['bre_nome'];
        } catch (PDOException $e) {
            echo "Erro ao obter nome da cidade: " . $e->getMessage();
        }
    }

    // Função para obter o nome do estado
    public function getBroNome() {
        try {
            global $pdo;

            $stmt = $pdo->prepare("SELECT bro_nome FROM brasil_estados WHERE bro_id = :bro_id");
            $stmt->bindParam(':bro_id', $this->bro_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['bro_nome'];
        } catch (PDOException $e) {
            echo "Erro ao obter nome do estado: " . $e->getMessage();
        }
    }

    // Função para salvar um novo contato no banco de dados
    public function salvarContato() {
        try {
            global $pdo;

            $stmt = $pdo->prepare("INSERT INTO contatos (con_nome, con_telefone, con_cpf, bre_id, bro_id) VALUES (:nome, :telefone, :cpf, :bre_id, :bro_id)");

            $stmt->bindParam(':nome', $this->con_nome);
            $stmt->bindParam(':telefone', $this->con_telefone);
            $stmt->bindParam(':cpf', $this->con_cpf);
            $stmt->bindParam(':bre_id', $this->bre_id);
            $stmt->bindParam(':bro_id', $this->bro_id);

            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao salvar contato: " . $e->getMessage());
            echo "Erro ao salvar contato: " . $e->getMessage();
        }
    }

    // Função para obter todos os contatos do banco de dados
    public static function obterTodosContatos() {
        try {
            global $pdo; // Certifique-se de que $pdo está definido globalmente

            $stmt = $pdo->query("SELECT * FROM contatos");
            $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $contatos;
        } catch (PDOException $e) {
            echo "Erro ao obter contatos: " . $e->getMessage();
        }
    }

    // Função para obter as informações de cidade e estado do banco de dados
    public static function obterInformacoesCidadeEstado() {
        try {
            global $pdo;

            $stmtCidades = $pdo->query("SELECT * FROM brasil_cidades");
            $cidades = $stmtCidades->fetchAll(PDO::FETCH_ASSOC);

            $stmtEstados = $pdo->query("SELECT * FROM brasil_estados");
            $estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);

            return ['cidades' => $cidades, 'estados' => $estados];
        } catch (PDOException $e) {
            echo "Erro ao obter informações de cidade e estado: " . $e->getMessage();
        }
    } 

    public static function obterContatoPorId($con_id) {
        try {
            global $pdo;

            $stmt = $pdo->prepare("SELECT * FROM contatos WHERE con_id = :con_id");
            $stmt->bindParam(':con_id', $con_id);
            $stmt->execute();
            $contato = $stmt->fetchObject('Contato');

            return $contato;
        } catch (PDOException $e) {
            echo "Erro ao obter contato por ID: " . $e->getMessage();
        }
    }

    // Função para atualizar as informações de um contato no banco de dados
    public function atualizarContato($con_id, $con_nome, $con_telefone, $con_cpf, $bre_id, $bro_id) {
        try {
            global $pdo;
    
            $stmt = $pdo->prepare("UPDATE contatos SET con_nome = :nome, con_telefone = :telefone, con_cpf = :cpf, bre_id = :bre_id, bro_id = :bro_id WHERE con_id = :con_id");
    
            $stmt->bindParam(':nome', $con_nome);
            $stmt->bindParam(':telefone', $con_telefone);
            $stmt->bindParam(':cpf', $con_cpf);
            $stmt->bindParam(':bre_id', $bre_id);
            $stmt->bindParam(':bro_id', $bro_id);
            $stmt->bindParam(':con_id', $con_id);
    
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar contato: " . $e->getMessage();
        }
    }

    // Função para excluir um contato do banco de dados
    public static function excluirContato($con_id) {
        try {
            global $pdo;

            $stmt = $pdo->prepare("DELETE FROM contatos WHERE con_id = :con_id");
            $stmt->bindParam(':con_id', $con_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir contato: " . $e->getMessage();
        }
    }
}
?>

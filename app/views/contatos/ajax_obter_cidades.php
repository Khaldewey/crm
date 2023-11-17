<?php

require_once '../../../app/config/database.php';

// Verifica se o parâmetro estado_id foi passado
if (isset($_POST['estado_id'])) {
    $estadoId = $_POST['estado_id'];

    // Consulta para obter cidades com base no estado selecionado
    $stmt = $pdo->prepare("SELECT * FROM brasil_cidades WHERE bro_id = :estado_id");
    $stmt->bindParam(':estado_id', $estadoId);
    $stmt->execute();

    // Retorna as cidades como JSON
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode(['error' => 'Parâmetro estado_id não foi fornecido.']);
}
?>

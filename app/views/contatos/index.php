<?php

// index.php

require_once '../../../app/controllers/contatosController.php';

// Cria uma instância do ContatosController
$contatosController = new ContatosController();
$contatos = $contatosController->index();
// Verifica a ação a ser realizada (editar, excluir, cadastrar, etc.)
// if (isset($_GET['action'])) {
//     // Lógica para as outras ações, se necessário
// } else {
//     // Se não houver uma ação específica, exibe a lista de contatos
//     $contatosController->index();
// }
?>

<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../assets/stylesheet/style.css" >

    <title>Lista de Contatos</title> 

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function filtrarContatos() {
                var filtro = $('#filtro').val().toLowerCase();

                // Oculta todas as linhas da tabela
                $('.contato-row').hide();

                // Exibe apenas as linhas que correspondem ao critério de filtragem
                $('.contato-row').filter(function() {
                    return $(this).text().toLowerCase().indexOf(filtro) !== -1;
                }).show();
            }

            $('#filtro').on('input', filtrarContatos);
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="titulo-tabela">Lista de Contatos</div>
        <div class="filtro-lista">
            <label for="filtro">Filtrar por Nome:</label>
            <input type="text" id="filtro" name="filtro" oninput="filtrarContatos()">
        </div>

        <?php if (!empty($contatos) && is_array($contatos)): ?>
            <table border="1">
                <tr>
                    
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($contatos as $contato): ?>
                    <tr class="contato-row">
                        
                        <td><?php echo $contato->getConNome(); ?></td>
                        <td><?php echo $contato->getConTelefone(); ?></td>
                        <td><?php echo $contato->getConCpf(); ?></td>
                        <td><?php echo $contato->getBreNome(); ?></td>
                        <td><?php echo $contato->getBroNome(); ?></td>
                        <td>
                            <div class="flex">
                                <a href="index.php?action=editar&con_id=<?php echo $contato->getConId(); ?>">
                                    <img src="../../assets/image/botao-editar.png" class="btn-editar">
                                </a>
                                <a href="index.php?action=excluir&con_id=<?php echo $contato->getConId(); ?>">
                                    <img src="../../assets/image/botao-excluir.png" class="btn-excluir">
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
        <?php else: ?>
            <p>Não há contatos cadastrados.</p>
        <?php endif; ?>

        <br>
        <div class="btn-novo-contato">
            <a href="index.php?action=cadastrar">cadastrar novo contato</a>
        </div>
    </div>
</body>
</html>

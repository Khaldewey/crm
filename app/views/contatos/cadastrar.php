<!-- app/views/contatos/cadastrar.php -->
<?php 
require_once '../../../app/controllers/contatosController.php';
?>

<html>
<head>
    <link rel="stylesheet" href="../../assets/stylesheet/style.css" >
    <title>Cadastrar Novo Contato</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Quando o valor do dropdown de estado é alterado
            $('#bro_id').change(function() {
                // Obtemos o valor selecionado
                var estadoId = $(this).val();

                // Fazemos uma requisição AJAX para obter as cidades do estado selecionado
                $.ajax({
                    type: 'POST',
                    url: 'ajax_obter_cidades.php', // Substitua pelo caminho real do seu arquivo PHP
                    data: { estado_id: estadoId },
                    dataType: 'json',
                    success: function(data) {
                        // Limpa as opções atuais do dropdown de cidade
                        $('#bre_id').empty();

                        // Adiciona as novas opções com base nos dados recebidos
                        $.each(data, function(key, value) {
                            $('#bre_id').append('<option value="' + value.bre_id + '">' + value.bre_nome + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="titulo-tabela">Cadastrar Novo Contato</div>
        <div class="flex">
            <form action="index.php?action=salvar" method="post" class="form-cadastro">
                <!-- Campos do formulário -->
                <div class="col-md-12 col-xs-12">
                    <label for="con_nome">Nome:</label>
                    <input type="text" name="con_nome" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="con_telefone">Telefone:</label>
                    <input type="text" name="con_telefone" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="con_cpf">CPF:</label>
                    <input type="text" name="con_cpf" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="bro_id">Estado:</label>
                    <select id="bro_id" name="bro_id" required>
                        <!-- Adicione as opções de estados aqui -->
                        <?php foreach ($informacoesCidadeEstado['estados'] as $estado): ?>
                            <option value="<?php echo $estado['bro_id']; ?>"><?php echo $estado['bro_nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="bre_id">Cidade:</label>
                    <select id="bre_id" name="bre_id" required>
                        <!-- As opções de cidade serão preenchidas dinamicamente pelo JavaScript -->
                    </select>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="flex">
                        <input type="submit" value="Cadastrar" class="btn-cadastro">
                        <a href="index.php" class="btn-sair">Sair</a>
                    </div>
                </div>
            </form>            
        </div>
    </div>
</body>
</html>

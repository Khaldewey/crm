<!-- app/views/contatos/editar.php -->
<?php 
require_once '../../../app/controllers/contatosController.php';
?>
<html>
<head>
    <title>Editar Contato</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('#bro_id').change(function() {
                
                var estadoId = $(this).val();

                // Requisição AJAX para obter as cidades do estado selecionado
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
        <div class="titulo-tabela">Editar Contato</div>
        <div class="flex">
            <form action="index.php?action=atualizar&con_id=<?php echo $contato->getConId(); ?>" method="post" class="form-cadastro">
            
                <div class="col-md-12 col-xs-12">
                    <label for="con_nome">Nome:</label>
                    <input type="text" name="con_nome" value="<?php echo $contato->getConNome(); ?>" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="con_telefone">Telefone:</label>
                    <input type="text" name="con_telefone" value="<?php echo $contato->getConTelefone(); ?>" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="con_cpf">CPF:</label>
                    <input type="text" name="con_cpf" value="<?php echo $contato->getConCpf(); ?>" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="bro_id">Estado:</label>
                    <select id="bro_id" name="bro_id" required>
                        <?php foreach ($informacoesCidadeEstado['estados'] as $estado): ?>
                            <option value="<?php echo $estado['bro_id']; ?>" <?php echo ($contato->getBroId() == $estado['bro_id']) ? 'selected' : ''; ?>><?php echo $estado['bro_nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="bre_id">Cidade:</label>
                    <select id="bre_id" name="bre_id" required>
                        <?php foreach ($informacoesCidadeEstado['cidades'] as $cidade): ?>
                            <option value="<?php echo $cidade['bre_id']; ?>" <?php echo ($contato->getBreId() == $cidade['bre_id']) ? 'selected' : ''; ?>><?php echo $cidade['bre_nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 col-xs-12">
                        <div class="flex">
                            <input type="submit" value="Atualizar" class="btn-cadastro">
                            <a href="index.php" class="btn-sair">Sair</a>
                        </div>
                    </div>
            </form> 
        </div>
    </div>
</body>
</html>

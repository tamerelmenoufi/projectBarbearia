<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['categoria']) $_SESSION['categoriaProduto'] = $_POST['categoria'];
    if($_POST['categoria_nome']) $_SESSION['categoriaProdutoNome'] = $_POST['categoria_nome'];

?>
<style>

</style>
<div class="p-3">
    <div class="row">
        <div lista class="col-md-12"></div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');
        $.ajax({
            url:"src/produtos/lista.php",
            success:function(dados){
                $("div[lista]").html(dados);
            }
        });
    })
</script>
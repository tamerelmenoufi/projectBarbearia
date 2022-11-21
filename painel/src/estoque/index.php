<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['produto']) $_SESSION['codProduto'] = $_POST['produto'];
    if($_POST['produto_nome']) $_SESSION['ProdutoNome'] = $_POST['produto_nome'];

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
            url:"src/estoque/lista.php",
            success:function(dados){
                $("div[lista]").html(dados);
            }
        });
    })
</script>
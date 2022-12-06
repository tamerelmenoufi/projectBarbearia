<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>

<h5>Carrinho de compras</h5>

Meu código de Compra é <?=$_SESSION['codVenda']?>

<script>
    $(function(){
        Carregando('none')
    })
</script>
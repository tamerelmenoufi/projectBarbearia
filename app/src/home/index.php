<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_GET['pedido']){
        $_SESSION['AppPedido'] = $_GET['pedido'];
    }
    if($_GET['cliente']){
        $_SESSION['AppCliente'] = $_GET['cliente'];
    }
    if($_GET['venda']){
        $_SESSION['AppVenda'] = $_GET['venda'];
    }

?>
<style>
    .bg_home{
        position:absolute;
        width:100%;
        height:100%;
        background-image:url("svg/fundo_home.svg");
        background-size:cover;
        background-color:#EAF3F0;
        opacity:0.05;
        display: flex;
        overflow:none;
    }

</style>
<div class="bg_home"></div>
<script>
    $(function(){
        Carregando();
        $.ajax({
                url:"src/home/home.php",
                data:{
                    cliente: '<?=$_SESSION['AppCliente']?>',
                    pedido: '<?=$_SESSION['AppPedido']?>',
                    venda: '<?=$_SESSION['AppVenda']?>',
                },
                success:function(dados){
                    $(".ms_corpo").html(dados);
                }
            });
    })
</script>

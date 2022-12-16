<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_SESSION['AppCliente']) $c = mysqli_fetch_object(mysqli_query($con, "select a.*, b.nome as loja from clientes a left join lojas b on a.loja = b.codigo where a.codigo = '{$_SESSION['AppCliente']}'"));
    if($_SESSION['AppPedido']) $m = mysqli_fetch_object(mysqli_query($con, "select * from mesas where codigo = '{$_SESSION['AppPedido']}' AND deletado != '1'"));
?>
<style>
    .topoImg{
        position:absolute;
        height:60px;
        margin-left:15px;
        margin-top:5px;
        transform: rotate(-10deg);
        z-index:2;

    }
    .DadosTopo{
        text-align:right;
        font-size:12px;
        padding:5px;
        margin-right:5px;
        color:#fff;
    }
    div[espaco]{
        margin-top:0px;
    }
    div[promocao_frete]{
        display:<?=(($promocao_taxa_zero)?'block':'none')?>;
    }
</style>
<div class="row">
    <div class="col-4">
        <img class="topoImg" src="img/logo.svg?<?=$md5?>" />
    </div>
    <div class="col-8">
        <?php
            if($c->telefone){
        ?>
            <div class="DadosTopo">
                <?=$c->telefone?>
                <div espaco></div>
                <span ClienteNomeApp><?=$c->nome?></span>
                <div espaco></div>
                <!-- <span TopoTituloLoja><?=$c->loja?></span> -->
            </div>
        <?php
            }
        ?>
    </div>
</div>

<script>

    setInterval(() => {
        $.ajax({
            url:"src/cliente/alert_pedido.php",
            success:function(dados){
                $(".alerta").html(dados);
            }
        });

    }, 5000);


    $(function(){

        <?php
           /* if(!$c->loja){
        ?>
        $(".ListaLojas").css("display","block");
        $.ajax({
            url:"componentes/ms_lojas.php",
            success:function(dados){
                $(".ListaLojas").html(dados);
            }
        });
        <?php
            }*/
        ?>

    })
</script>
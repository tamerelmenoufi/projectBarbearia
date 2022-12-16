<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_GET['loja']){
        mysqli_query($con, "update clientes set loja = '{$_GET['loja']}' where codigo = '{$_SESSION['AppCliente']}'");
        exit();
    }

?>
<style>
    .PainelLojas{
        padding:10px;
    }
    .btn-lojas{
        background-color:#502314;
        color:#fff;
    }
    .LojaTitulo{
        text-align:center;
        color:#333;
        font-size:12px;
        font-weight:bold;
        margin:20px;
    }
    .topoImgLoja{
        position:relative;
        height:120px;
        left:50%;
        margin-left:-60px;
        margin-bottom:20px;
        transform: rotate(-10deg);
        z-index:2;

    }
</style>

<div class="PainelLojas">
    <div class="row">
        <div class='col'>
            <div class="LojaTitulo">Selecione a Loja se sua preferência</div>
            <img class="topoImgLoja" src="img/logo.svg?<?=$md5?>" />
            <?php
                $query = "select * from lojas where situacao = '1' order by nome";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
            ?>
            <button class="btn btn-lojas btn-block mb-2" loja="<?=$d->codigo?>"><?=strtoupper($d->nome)?></button>
            <?php
                }
            ?>
        </div>
    </div>
</div>
<script>
    $(function(){

        $("button[loja]").click(function(){
            loja = $(this).attr('Loja');
            descricao = $(this).text();
            $.ajax({
                url:"componentes/ms_lojas.php",
                data:{
                    loja
                },
                success:function(dados){
                    $("span[TopoTituloLoja]").html(descricao);
                    $(".ListaLojas").css("display","none");
                }
            });
        });

    })
</script>
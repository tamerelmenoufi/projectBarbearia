<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .alerta{
        position:fixed;
        width:0;
        height:0;
        left:0;
        top:0;
        z-index:10;
    }

    .topo{
        position:fixed;
        width:100%;
        height:60px;
        background:#502314;
        left:0;
        top:0;
        z-index:2;
    }

    .rodape{
        position:fixed;
        width:100%;
        height:65px;
        background:#502314;
        left:0;
        bottom:0;
    }
    .rodape .row .col{
        color:#fff;
        text-align:center;
        font-size:30px;
    }
    .rodape .row .col p{
        font-size:10px;
        text-align:center;
        color:#fff;
        padding:0;
        margin:0;
    }

    .categorias_home{
        position:fixed;
        top:60px;
        padding-top:5px;
        padding-bottom:5px;
        width:100%;
        height:125px;
        background:#502314;
    }

    .pagina{
        position:fixed;
        top:185px;
        bottom:65px;
        width:100%;
        background:#502314; /*f5ebdc*/
        z-index:1;
    }

    .pagina div[dados]{
        position:fixed;
        top:195px;
        bottom:65px;
        left:5px;
        right:5px;
        overflow:auto;
        background:#fff; /*f5ebdc*/
        border-top-left-radius:25px;
        border-top-right-radius:25px;
        padding:10px;
    }



    .categoria_combo{
        position:relative;
        width:100%;
        margin-bottom:15px;

    }

    .ListaLojas{
        position:fixed;
        top:0;
        left:0;
        right:0;
        bottom:0;
        background-color:#fff;
        z-index:999;
        display:none;
    }

    .MensagemAddProduto2 {
        position: fixed;
        left: 50%;
        margin-left:-100px;
        bottom: 80px;
        background-color: rgb(75, 192, 192, 1);
        color: #fff;
        text-align: center;
        font-weight: bold;
        border-color:rgb(75, 192, 192, 1);
        border-radius: 5px;
        padding: 5px;
        width: 200px;
        z-index: 3;
        display: none;
    }

    .MensagemAddProduto2 span {
        position: absolute;
        left:50%;
        margin-left:-10px;
        font-size: 30px;
        top: 10px;
        color: rgb(75, 192, 192, 1);
    }

</style>

<!-- Informativo de pedidos ativos -->

<div class="MensagemAddProduto2 animate__animated animate__shakeY">
    Produto Adicionado!
    <span><i class="fa-solid fa-caret-down"></i></span>
</div>

<!-- Informativo de pedidos ativos -->

<!-- <div class="alerta"></div> Liberar este comentário para os alertas de pagamentos pendentes (PIX) -->

<div class="topo"></div>

<div class="categorias_home"></div>

<div class="pagina">

    <div dados>
        <div class="categoria_combo"></div>
<!-- <?php
    $query = "select * from categorias where deletado != '1' and situacao = '1' and categoria != 'COMBOS'";
    $result = mysqli_query($con,$query);
    while($d = mysqli_fetch_object($result)){
?>
    <button
            class="btn btn-danger btn-lg btn-block"
            acao<?=$md5?>
            local="src/produtos/produtos.php?categoria=<?=$d->codigo?>"
            janela="ms_popup_100"
    >
        <?=$d->categoria?>
    </button>
<?php
    }
?> -->
    </div>
</div>
<div class="rodape"></div>

<div class="ListaLojas"></div>

<script>
    $(function(){

        Carregando('none');

        $.ajax({
            url:"componentes/ms_topo.php",
            success:function(dados){
                $(".topo").html(dados);
            }
        });

        $.ajax({
            url:"componentes/ms_rodape.php",
            success:function(dados){
                $(".rodape").html(dados);
            }
        });


        $.ajax({
            url:"componentes/ms_categorias_scroll.php",
            success:function(dados){
                $(".categorias_home").html(dados);
            }
        });


        $.ajax({
            url:"componentes/ms_combos.php",
            success:function(dados){
                $(".categoria_combo").html(dados);
            }
        });



        $("button[acao<?=$md5?>]").off('click').on('click',function(){

            AppPedido = window.localStorage.getItem('AppPedido');
            AppCliente = window.localStorage.getItem('AppCliente');

            if(!AppCliente || AppCliente === null || AppCliente === undefined){

                Carregando();
                $.ajax({
                    url:"componentes/ms_popup_100.php",
                    type:"POST",
                    data:{
                        local:"src/cliente/cadastro.php",
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });

            }else{
                local = $(this).attr('local');
                janela = $(this).attr('janela');
                Carregando();
                $.ajax({
                    url:"componentes/"+janela+".php",
                    type:"POST",
                    data:{
                        local,
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });
            }
        })



    })

</script>
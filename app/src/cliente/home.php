<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

?>
<style>
    .ClienteTopoTitulo{
        position:relative;
        width:100%;
        text-align:center;
    }
    button[acao], button[sair], button[opc="lojas"]{
        text-align:left !important;
    }
</style>

<div class="ClienteTopoTitulo">
    <h4>
        <i class="fa-solid fa-user"></i> Sobre o Cliente
    </h4>
</div>

<div class="col">
    <div class="col-12">

        <button acao opc="perfil" class="btn btn-dark btn-lg btn-block">
            <i class="fa-solid fa-user-pen"></i> Perfil pessoal
        </button>
        <button opc="enderecos" acao class="btn btn-dark btn-lg btn-block">
            <i class="fa-solid fa-envelope"></i> Endereços
        </button>
        <!-- <button opc="lojas" class="btn btn-dark btn-lg btn-block">
            <i class="fa-solid fa-envelope"></i> Lojas
        </button> -->
        <button opc="pedidos" acao class="btn btn-dark btn-lg btn-block">
            <i class="fa-solid fa-bell-concierge"></i> Meus Pedidos
        </button>
        <!-- <button acao opc="senha" class="btn btn-dark btn-lg btn-block">
            <i class="fa-solid fa-key"></i> Alterar Senha
        </button> -->
        <button sair class="btn btn-danger btn-lg btn-block">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            Desconectar
        </button>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');
        $("button[acao]").click(function(){
            local = $(this).attr("opc");
            Carregando();
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:`src/cliente/${local}.php`,
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

        $('button[opc="lojas"]').click(function(){

            $(".ListaLojas").css("display","block");
            $.ajax({
                url:"componentes/ms_lojas.php",
                success:function(dados){
                    PageClose();
                    $(".ListaLojas").html(dados);
                }
            });

        });

        $("button[sair]").click(function(){

            $.confirm({
                content:"Deseja realmente desconectar do aplicativo?",
                title:false,
                buttons:{
                    'SIM':function(){

                        $.ajax({
                            url:"src/produtos/pedido.php",
                            type:"POST",
                            data:{
                                acao:'SairPedido',
                            },
                            success:function(dados){

                                window.localStorage.removeItem('AppPedido');
                                window.localStorage.removeItem('AppCliente');
                                window.localStorage.removeItem('AppVenda');


                                $.ajax({
                                    url:"src/home/index.php",
                                    success:function(dados){
                                        $(".ms_corpo").html(dados);
                                    }
                                });

                            }
                        });

                    },
                    'NÃO':function(){

                    }
                }
            });

        });


    })
</script>
<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    $q = "select * from clientes where codigo = '{$_SESSION['AppCliente']}'";
    $c = mysqli_fetch_object(mysqli_query($con, $q));

    if($_POST['envio'] == 'sms'){

        $cod = strtoupper(substr(md5($_SESSION['AppCliente']),0,6));

        $content = http_build_query(array(

            'num' => '55'.str_replace(array(' ','(',')','-'), false, trim($c->telefone)),
            'msg' => "BKManaus Informa: Seu codido de confirmacao e {$cod}.",

        ));

        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'content' => $content,
            )
        ));

        $result = file_get_contents('http://moh1.com.br/fnbk2.php', null, $context);

        $retorno = ['status' => true, 'retorno' => json_decode($result)];

        $retorno = json_encode($retorno);
        echo $retorno;
        exit();

    }

    if($_POST['envio'] == 'whatsapp'){

        $cod = strtoupper(substr(md5($_SESSION['AppCliente']),0,6));
        $num = trim($c->telefone);
        $msg = "BKManaus Informa: Seu codido de confirmacao é: *{$cod}*";

        $result = EnviarWapp($num,$msg);

        $retorno = ['status' => true, 'retorno' => json_decode($result)];

        $retorno = json_encode($retorno);
        echo $retorno;

        exit();

    }


?>

<style>
    .ClienteTopoTitulo{
        position:relative;
        width:100%;
        text-align:center;
    }
</style>

<div class="ClienteTopoTitulo">
    <h4>
        <i class="fa-solid fa-user"></i> Confirmar Telefone
    </h4>
</div>

<div class="col">
    <div class="col-12">
        <p style="text-align:center">
        O seu telefone <b><?=$c->telefone?></b> informado no cadastro, precisa ser confirmado para liberar o seu cadastro.
        Como deseja receber o código de confirmação?
        </p>
        <button tipo="sms" class="btn btn-primary btn-block btn-lg"><i class="fa-solid fa-comment-sms"></i> SMS</button>
        <button tipo="whatsapp" class="btn btn-primary btn-block btn-lg"><i class="fa-brands fa-whatsapp"></i> WHATSAPP</button>
        <button class="ativar btn btn-success btn-block btn-lg"><i class="fa-solid fa-keyboard"></i> Digitar Código</button>

    </div>
</div>


<script>
    $(function(){

        $("button[tipo]").click(function(){
            envio = $(this).attr("tipo");
            Carregando();
            $.ajax({
                url:"src/cliente/confirmar_telefone.php",
                data:{
                    envio,
                },
                type:"POST",
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    if(retorno.status){
                        $.ajax({
                            url:"componentes/ms_popup.php",
                            type:"POST",
                            data:{
                                local:"src/cliente/validar.php",
                            },
                            success:function(dados){
                                Carregando('none');
                                PageClose();
                                $(".ms_corpo").append(dados);
                            }
                        });
                    }else{
                        $.alert('Ocorreu um erro. Tente novamente!');
                    }
                }
            });
        });


        $("button.ativar").click(function(){
            Carregando();

            $.ajax({
                url:"componentes/ms_popup.php",
                type:"POST",
                data:{
                    local:"src/cliente/validar.php",
                },
                success:function(dados){
                    Carregando('none');
                    PageClose();
                    $(".ms_corpo").append(dados);
                }
            });

        })

    })
</script>
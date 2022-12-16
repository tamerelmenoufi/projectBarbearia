<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $q = "select * from clientes where codigo = '{$_SESSION['AppCliente']}'";
    $c = mysqli_fetch_object(mysqli_query($con, $q));

    if($_POST['acao'] == 'validacao'){

        $codigo = strtoupper(substr(md5($_SESSION['AppCliente']),0,6));

        if($codigo == strtoupper($_POST['codigo'])){
            mysqli_query($con, "update clientes set telefone_confirmado = '1' where codigo = '{$_SESSION['AppCliente']}'");
            $retorno = ['status' => true, 'ativacao' => $codigo, 'codigo' => $_POST['codigo']];
        }else{
            $retorno = ['status' => false, 'ativacao' => $codigo, 'codigo' => $_POST['codigo']];
        }

        echo json_encode($retorno);

        exit();
    }


?>

<style>
    .ClienteTopoTitulo{
        position:relative;
        width:100%;
        text-align:center;
    }
    #codigo_ativacao{
        text-align:center;
        text-transform: uppercase;

    }
</style>

<div class="ClienteTopoTitulo">
    <h4>
        <i class="fa-solid fa-user"></i> Código de Ativação
    </h4>
</div>

<div class="col">
    <div class="col-12">
        <p style="text-align:center">
        Enviamos um código com 6(seis) dígitos para o número cadastrado <b><?=$c->telefone?></b>. Digite o código enviado no campo abaixo para validar o seu cadastro.
        </p>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="codigo_ativacao" maxlength="6" />
        <button class="enviar_codigo btn btn-success btn-block btn-lg"><i class="fa-brands fa-whatsapp"></i> Ativar</button>

    </div>
</div>


<script>
    $(function(){

        $("button.enviar_codigo").click(function(){
            codigo = $("#codigo_ativacao").val();
            Carregando();
            $.ajax({
                url:"src/cliente/validar.php",
                data:{
                    codigo,
                    acao:'validacao',
                },
                type:"POST",
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    local = $("body").attr("retorno");
                    if(retorno.status){
                        $.ajax({
                            url:"componentes/ms_popup_100.php",
                            type:"POST",
                            data:{
                                local,
                            },
                            success:function(dados){
                                Carregando('none');
                                PageClose(2);
                                $(".ms_corpo").append(dados);
                            }
                        });
                    }else{
                        Carregando('none');
                        $.alert('Ocorreu um erro. Tente novamente!');
                    }
                }
            });
        });

    })
</script>
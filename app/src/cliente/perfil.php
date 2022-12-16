<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'salvar'){
        $query = "update clientes set
                                    nome = '{$_POST['nome']}',
                                    email = '{$_POST['email']}',
                                    cpf = '{$_POST['cpf']}'
            where codigo = '{$_SESSION['AppCliente']}'";
        mysqli_query($con, $query);

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso',
            'nome' => $_POST['nome'],
        ]);

        exit();
    }

    $c = mysqli_fetch_object(mysqli_query($con, "select * from clientes where codigo = '{$_SESSION['AppCliente']}'"));

?>
<style>
    .PedidoTopoTitulo{
        position:fixed;
        left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        z-index:1;
    }
    .ConfirmaTelefone{
        width:100%;
        margin-top:20px;
        padding:10px;
        text-align:center;
        border:solid 1px red;
        color:red;
        border-radius:10px;
    }

</style>
<div class="PedidoTopoTitulo">
    <h4>Perfil do Cliente</h4>
</div>
<div class="col" style="margin-bottom:60px;">
    <div class="row">
            <div class="col-12">

                <div class="form-group">
                    <label for="nome">
                        Telefone*
                        <?php
                        if(!$c->telefone_confirmado){
                        ?>
                        <span class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Não Confirmado</span>
                        <?php
                        }
                        ?>
                    </label>
                    <div class="form-control form-control-lg" style="cursor:pointer; background-color:#ccc;"><?=$c->telefone?></div>
                </div>

                <div class="form-group">
                    <label for="nome">Nome Completo*</label>
                    <input type="text" class="form-control form-control-lg" id="nome" placeholder="Seu Nome Completo" value="<?=$c->nome?>">
                </div>
                <div class="form-group">
                    <label for="nome">CPF*</label>
                    <input type="text" class="form-control form-control-lg" id="cpf" inputmode="numeric" placeholder="CPF" value="<?=$c->cpf?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail*</label>
                    <input type="email" class="form-control form-control-lg" id="email" placeholder="seuemail@seudominio.com" value="<?=$c->email?>">
                </div>
                <div style="padding:20px; text-align:right; color:#a1a1a1; font-size:10px; width:100%;"><b>* Dados Obrigatórios</b></div>
                <button SalvarDados type="buttom" class="btn btn-secondary btn-lg">Salvar dados</button>
            </div>

            <?php
            if(!$c->telefone_confirmado){
            ?>
            <div class="col-12">
                <div class="ConfirmaTelefone">
                        Seu Cadastro não está completo, é necessário confirmar o seu telefone.<br>
                        <span class="text-primary">Clique aqui e confirme agora!</span>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(function(){

        $("#cpf").mask("999.999.999-99");

        $("button[SalvarDados]").click(function(){
            nome = $("#nome").val();
            email = $("#email").val();
            cpf = $("#cpf").val();

            if(!nome || !email || !cpf){
                $.alert({
                    content:'Preencha os campos obrigatórios(*) no formulário!',
                    title:false,
                    type: "red",
                });
                return false;
            }

            $.ajax({
                url:"src/cliente/perfil.php",
                type:"POST",
                data:{
                    nome,
                    email,
                    cpf,
                    acao:'salvar'
                },
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    //$.alert(retorno.status);
                    if(retorno.status){
                        $.alert({
                            content:'Dados salvos com sucesso!',
                            title:false,
                            type: "green",
                        });

                        retorno2 = $("body").attr("retorno");
                        local = ((retorno2)?retorno2:"src/cliente/enderecos.php");
                        $("body").attr("retorno",'');
                        if(retorno2){
                            $.ajax({
                                url:"componentes/ms_popup_100.php",
                                type:"POST",
                                data:{
                                    local,
                                },
                                success:function(dados){
                                    PageClose(2);
                                    $(".ms_corpo").append(dados);
                                }
                            });
                        }else{
                            $("span[ClienteNomeApp]").html(retorno.msg);
                            PageClose();
                        }


                    }
                }
            });

        });



        $(".ConfirmaTelefone").click(function(){
            $.ajax({
                url:"componentes/ms_popup.php",
                type:"POST",
                data:{
                    local:"src/cliente/confirmar_telefone.php",
                },
                success:function(dados){
                    $("body").attr("retorno","src/cliente/perfil.php");
                    $(".ms_corpo").append(dados);
                }
            });
        });

    })
</script>
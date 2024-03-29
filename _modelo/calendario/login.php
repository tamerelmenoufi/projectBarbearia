<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'login'){

        $query = "select * from clientes where telefone = '{$_POST['telefone']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);
        if($d->codigo){
            $characters = '0123456789';
            $chave = substr(str_shuffle($characters), 0, 4);
            mysqli_query($con, "update clientes set chave = '{$chave}' where codigo = '{$d->codigo}'");
            SendWapp($d->telefone, "Os Manos Barbearia: Para logar na sua conta, digite o código *{$chave}*");
            $result = 'sucesso';
        }else{
            $result = 'erro';
        }

        echo $result;

        exit();

    }

?>


<div class="container">
    <div class="row">
        <div class="col">
            <div class="card p-3">

                <p>Para fazer o login, digite no campo abaixo o número de telefone cadastrado para receber a sua chave de acesso.</p>

                <div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" aria-describedby="telefoneHelp">
                        <div id="telefoneHelp" class="form-text">(Informe o número de telefone cadastrado.)</div>
                    </div>
                    <button type="button" class="btn btn-secondary logar">Entrar</button>
                </div>
                <p class="m-3"><a href="#login" style="font-weight:bold;border-bottom: 2px #e9e5e5 solid;" novoCadastro>Não tem cadastro, clique aqui</a></p>

            </div>
        </div>
    </div>
</div>

<script>

    $(function(){

        $("#telefone").mask("(99) 99999-9999");

        $(".logar").click(function(){
            telefone = $("#telefone").val();
            $.ajax({
                url:"calendario/login.php",
                data:{
                    telefone,
                    acao:'login'
                },
                type:"POST",
                success:function(dados){

                    if(dados.trim() == 'sucesso'){
                        $.ajax({
                            url:"calendario/chave.php",
                            data:{
                                telefone,
                            },
                            type:"POST",
                            success:function(dados){
                                $(".LateralDireita").html(dados);
                            }
                        });
                    }else{
                        $.alert(" O login não pode ser realizado.<br>Dados incorretos ou usuários não cadastrado.");
                        return false;
                    }


                }
            });
        });


        $("a[novoCadastro]").click(function(){
            $.ajax({
                url:"clientes/form.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });
    })

</script>
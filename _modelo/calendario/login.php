<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'login'){

        $query = "select * from clientes where telefone = '{$_POST['telefone']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);
        if($d->codigo){
            SendWapp($d->telefone, "Os Manos Barbearia: Para logar na sua conta, digite o código *123456*");
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



                <div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" aria-describedby="telefoneHelp">
                        <div id="telefoneHelp" class="form-text">Informe o número de telefone cadastrado.</div>
                    </div>
                    <button type="button" class="btn btn-primary logar">Entrar</button>
                </div>
                <p class="m-3"><a href="#login" novoCadastro>Não tem cadastro, clique aqui</a></p>

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

                    if(dados == 'sucesso'){
                        $.ajax({
                            url:"calendario/home.php",
                            success:function(dados){
                                $(".LateralDireita").html(dados);
                            }
                        });
                    }else{
                        $.alert(dados+" O login não pode ser realizado.<br>Dados incorretos ou usuários não cadastrado.");
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
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'chave'){

        echo $query = "select * from clientes where telefone = '{$_POST['telefone']}' and chave = '{$_POST['chave']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);
        if($d->codigo){
            $_SESSION['cliente'] = $d->codigo;
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
                        <div class="form-control"><?=$_POST['telefone']?></div>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Chave</label>
                        <input type="text" class="form-control" id="chave" aria-describedby="chaveHelp">
                        <div id="chaveHelp" class="form-text">Enviamos um código chave no seu número WhatsApp. Digite no campo acima.</div>
                    </div>
                    <button type="button" class="btn btn-primary logar">Entrar</button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

    $(function(){

        $("#chave").mask("9999");

        $(".logar").click(function(){
            chave = $("#chave").val();
            $.ajax({
                url:"calendario/chave.php",
                data:{
                    chave,
                    telefone:'<?=$_POST['telefone']?>',
                    acao:'chave'
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
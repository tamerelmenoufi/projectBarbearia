<?php
    include("../conf.php");

    if($_GET['s']) $_SESSION = [];
?>
<style>
    .ContainerLogin{
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
        align-items: center;
        justify-items: center;
        justify-content: center;

    }

</style>

<div class="ContainerLogin">
    <div class="card m-3 p-3">
        <h5>Dados de acesso</h5>
        <div class="form-group mb-2">
            <label for="login">Login</label>
            <input type="text" class="form-control form-control-lg" id="login" placeholder="Digite seu login">
        </div>

        <div class="form-group mb-2">
            <label for="senha">Senha</label>
            <input type="text" class="form-control form-control-lg" id="senha" placeholder="Digite sua senha">
        </div>
        <button logar type="button" class="btn btn-primary btn-lg">Logar</button>
    </div>
</div>

<script>
    $(function(){

        Carregando('none');

        $("button[logar]").click(function(){

            Carregando();
            login = $("#login").val();
            senha = $("#senha").val();

            $.ajax({
                url: "src/pedidos/home/index.php",
                type:"POST",
                dataType:"JSON",
                data:{
                    login,
                    senha,
                    acao:'logar'
                },
                success: function (dados) {
                    console.log(dados);
                    if(dados.status){
                        $.ajax({
                            url: "src/pedidos/home/index.php",
                            success: function (dados) {
                                $(".ms_corpo").html(dados);
                                Carregando('none')
                            }
                        });
                    }else{
                        Carregando('none')
                    }
                    $.alert(dados.mensagem)
                    //$(".ms_corpo").html(dados);
                }
             });

        });

    })
</script>
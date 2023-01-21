<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'login'){
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);

        $query = "select * from colaboradores where email = '{$email}' and senha = '{$senha}'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result)){
            $d = mysqli_fetch_object($result);
            $_SESSION['ProjectPainel'] = $d;
            $_SESSION['PeriodoLoja'] = mysqli_fetch_object(mysqli_query($con, "select * from configuracoes where codigo = '1'"));
            $retorno = [
                'sucesso' => true,
                'ProjectPainel' => $d->codigo,
                'MaterConnectado' => $_POST['MaterConnectado'],
                'msg' => 'Login Realizado com sucesso',
            ];
        }else{
            $retorno = [
                'sucesso' => false,
                'ProjectPainel' => false,
                'MaterConnectado' => false,
                'msg' => 'Ocorreu um erro no seu login',
            ];
        }
        echo json_encode($retorno);
        exit();
    }
?>
<style>
.pagina{
    position:fixed;
    left:0;
    top:0;
    bottom:0;
    right:0;
    width:100%;
    height: 100%;
    background-repeat: no-repeat;
    /* background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33)); */
    /* background-image: linear-gradient(#19ae46, #ffffff); */
    background-color:#333;
}

.card-container.card {
    width: 350px;
    padding: 40px 40px;
    border-radius:5px;
}


/*
 * Card component
 */
.card {
    background-color: #F7F7F7;
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
    width: 150px;
    height: auto;
    margin: 0 auto 10px;
    display: block;
}

/*
 * Form styles
 */
.profile-name-card {
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin: 10px 0 0;
    min-height: 1em;
}

.reauth-email {
    display: block;
    color: #404040;
    line-height: 2;
    margin-bottom: 10px;
    font-size: 14px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin #inputEmail,
.form-signin #inputPassword {
    direction: ltr;
    height: 44px;
    font-size: 16px;
}

.form-signin input[type=email],
.form-signin input[type=password],
.form-signin input[type=text],
.form-signin button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    z-index: 1;
    position: relative;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    border-color: rgb(104, 145, 162);
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
}

.forgot-password {
    color: rgb(104, 145, 162);
}

.forgot-password:hover,
.forgot-password:active,
.forgot-password:focus{
    color: rgb(12, 97, 33);
}

.btn-primary {
    --bs-btn-color: #fff;
    --bs-btn-bg: #4a3019;
    --bs-btn-border-color: #4a3019;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #4a3019;
    --bs-btn-hover-border-color: #4a3019;
    --bs-btn-focus-shadow-rgb: 49,132,253;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #4a3019;
    --bs-btn-active-border-color: #4a3019;
    --bs-btn-active-shadow: inset 0 3px 5pxrgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #4a3019;
    --bs-btn-disabled-border-color: #4a3019;
}

body {

    background: url(img/fundo-bar.jpg) no-repeat center fixed;
    background-size: auto auto;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}

</style>
<div class="">
    <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="img/logo.png" />
            <!-- <p id="profile-name" class="profile-name-card"></p> -->

            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="email" placeholder="Digite seu E-mail" required autofocus>
                <label for="email">Digite seu E-mail</label>
            </div>

            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="senha" placeholder="Digite sua Senha" required>
                <label for="senha">Senha</label>
            </div>
            <div id="remember" class="checkbox mb-2 mt-2">
                <label>
                    <input type="checkbox" value="remember-me"> Manter-me sempre conectado
                </label>
            </div>
            <button id="Acessar" class="btn btn-lg btn-primary btn-block btn-signinXX" type="submit">Entrar</button>

            <!-- <div class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="login" class="form-control" placeholder="Login">
                <input type="password" id="senha" class="form-control" placeholder="Senha" required>
                <div id="remember" class="checkbox mb-1 mt-1">
                    <label>
                        <input type="checkbox" value="remember-me"> Manter-me sempre conectado
                    </label>
                </div>

            </div> -->
            <a href="#" class="forgot-password">
                Esqueceu a senha?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
</div>

<script>
    $(function(){
        Carregando('none');
        AcaoBotao = ()=>{
            email = $("#email").val();
            senha = $("#senha").val();
            Carregando();
            $.ajax({
                url:"src/login/index.php",
                type:"POST",
                dataType:"json",
                data:{
                    acao:'login',
                    email,
                    senha
                },
                success:function(dados){
                    // let retorno = JSON.parse(dados);
                    // $.alert(dados.sucesso);
                    console.log(dados.ProjectPainel);
                    if(dados.ProjectPainel > 0){
                        window.location.href='./';
                    }else{
                        $.alert('Ocorreu um erro.<br>Favor confira os dados do login.')
                        Carregando('none');
                    }

                }
            });
        };

        $("#Acessar").click(function(){
            AcaoBotao();
        });

        $(document).on('keypress', function(e){

            var key = e.which || e.keyCode;
            if (key == 13) { // codigo da tecla enter
                AcaoBotao();
            }


        });

    })
</script>
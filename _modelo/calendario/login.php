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
                Informe o número de telefone cadastrado
            </div>
        </div>
    </div>
</div>
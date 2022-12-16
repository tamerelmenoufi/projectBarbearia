<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $tempo = date("Y-m-d H:i:s", mktime((date("H") - 12), date("i"), date("s"), date("m"), date("d"), date("Y")));

    $query = "select * from vendas where
                                    data_pedido >= '{$tempo}' and
                                    cliente = '{$_SESSION['AppCliente']}' and
                                    forma_pagamento = 'pix' and
                                    operadora_situacao = 'pending' and
                                    deletado != '1'
                                    ";
    $result = mysqli_query($con, $query);
    // $d = mysqli_fetch_object($result);
    $n = mysqli_num_rows($result);
    if($n){

?>
<style>
    .alerta{
        position:fixed;
        width:auto;
        height:50px;
        left:10px;
        top:10px;
        padding:10px;
        border-radius:7px;
        border:solid 1px #333;
        background-color:#ccc;
        z-index:10;
    }
</style>
<i class="fa-brands fa-pix"></i> Você possui <?=$n?> pagamento(s) pendente(s);
<?php
    }
?>
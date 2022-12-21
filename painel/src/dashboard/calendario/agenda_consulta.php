<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $query = "select * from agenda where codigo = '{$_POST['codigo']}'";
    // $result = mysqli_query($con, )
?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>"><?=date("d/m/Y H:i")?></h4>

Consulta da agenda de número <?=$_POST['codigo']?>
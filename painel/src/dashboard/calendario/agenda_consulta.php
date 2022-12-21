<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>">Editar Endereço</h4>

Consulta da agenda de número <?=$_POST['codigo']?>
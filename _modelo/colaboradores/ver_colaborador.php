<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $query = "select * from colaboradores where codigo = '{$_POST['colaborador']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>

<h4 class="Titulo<?=$md5?>"><d style="color:#918d87"><?=$d->nome?></d></h4>


<div class="card">
    <img src="<?=$localPainel?>src/volume/colaboradores/<?=$d->foto?>" class="card-img-top" >
    <div class="card-body">
        <h5 class="card-title"><?=$d->especialidade?></h5>
        <p class="card-text"><?=$d->curriculo?></p>
    </div>
</div>

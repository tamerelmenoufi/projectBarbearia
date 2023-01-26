<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");


    $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.codigo = '{$_POST['cod']}'";
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

<h4 class="Titulo<?=$md5?>"><d style="color:#918d87">Agenda <span Titulo></span></d></h4>

<div class="container">
    <div class="row">

    <div class="card">
        <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" class="card-img-top" >
        <div class="card-body">
            <h5 class="card-title"><?=$d->produto?></h5>
            <p class="card-text"><?=$d->descrcao?></p>
            <a href="#" class="btn btn-primary">R$ <?=number_format($d->valor,2,',','.')?></a>
        </div>
    </div>

    </div>
</div>
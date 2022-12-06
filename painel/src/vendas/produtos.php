<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");


    if($_POST['codCategoria']){
        $_SESSION['codCategoria'] = $_POST['codCategoria'];
    }
    if($_POST['codCategoria'] == 'tudo') $_SESSION['codCategoria'] = false;

    if($_SESSION['codCategoria']){ $categoria = "and categoria = '{$_SESSION['codCategoria']}'"; }



?>
<style>

</style>
<div class="row">
<?php

    $query = "select * from produtos where situacao = '1' {$categoria} order by vendas desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

    // for($i=0;$i<10;$i++){
?>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?=$d->produto?></h5>
                    <p class="card-text"><?=$d->descricao?></p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>
<script>
    $(function(){
        Carregando('none');

    })
</script>
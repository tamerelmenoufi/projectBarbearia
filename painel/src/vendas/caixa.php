<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .elementos{
        position:relative;
        white-space:nowrap;
        float:left;
        margin:5px;
    }
</style>
<div class="p-3" style="position:fixed; left:0px; top:65px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-clock" style="margin-right:10px;"></i>Profissional</span>
                <div class="form-control"></div>
                <button class="btn btn-outline-secondary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-check" style="margin-right:10px;"></i>Cliente</span>
                <div class="form-control"></div>
                <button class="btn btn-outline-secondary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    </div>
    <div class="main-carousel">
        <?php
            $query = "select * from produtos_categorias where situacao = '1' order by categoria asc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            // for($i=0;$i<30;$i++){
        ?>
        <div class="carousel-cell elementos">
            <button class="btn btn-secondary btn-block"><?=$d->categoria?></button>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<div class="p-3" style="position:fixed; left:0px; top:235px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div class="col-md-6">

        <?php

        $query = "select * from produtos where situacao = '1' order by produto asc";
        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){

        // for($i=0;$i<10;$i++){
        ?>

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
        <?php
        }
        ?>

        </div>

        <div class="col-md-6">

        </div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');

        $('.main-carousel').flickity({
            // options
            cellAlign: 'left',
            contain: true,
            freeScroll: true,
            prevNextButtons: false,
            pageDots: false
        });
    })
</script>
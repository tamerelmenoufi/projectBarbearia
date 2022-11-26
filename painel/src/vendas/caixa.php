<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .elementos{
        width:auto;
        height:60px;
        border:1px red solid;
        position:relative;
        white-space:nowrap;
        float:left;
        margin:5px;
        cursor:pointer;
    }
</style>
<h5>Dados do caixa</h5>

<div class="input-group mb-3">
    <span class="input-group-text">Profissional</span>
    <div class="form-control"></div>
    <button class="btn btn-outline-secondary" type="button">Buscar</button>
    <span class="input-group-text">Cliente</span>
    <div class="form-control"></div>
    <button class="btn btn-outline-secondary" type="button">Buscar</button>
</div>

<div class="main-carousel">
    <?php
        for($i=0;$i<30;$i++){
    ?>
    <div class="carousel-cell elementos">
        <button class="btn btn-secondary btn-block">Coluna <?=$i?></button>
    </div>
    <?php
        }
    ?>
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
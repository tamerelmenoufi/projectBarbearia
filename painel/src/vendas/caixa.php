<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .elementos{
        width:auto;
        height:60px;
        padding:20px;
        border:1px red solid;
        position:relative;
        white-space:nowrap;
        float:left;
        margin:5px;
        cursor:pointer;
    }
</style>
<h5>Dados do caixa</h5>
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
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<h5>Dados do caixa</h5>
<div class="main-carousel">
    <?php
        for($i=0;$i<30;$i++){
    ?>
    <div class="carousel-cell"> Coluna <?=$i?></div>
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
            contain: true
        });
    })
</script>
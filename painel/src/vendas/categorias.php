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
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
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
    <div class="carousel-cell elementos">
        <button abrir_categoria="tudo" class="btn btn-primary btn-block">Todos os Produtos</button>
    </div>
    <?php
        $query = "select * from produtos_categorias where situacao = '1' order by categoria asc";
        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){
        // for($i=0;$i<30;$i++){
    ?>
    <div class="carousel-cell elementos">
        <button abrir_categoria="<?=$d->codigo?>" class="btn btn-secondary btn-block"><?=$d->categoria?></button>
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

        $("button[abrir_categoria]").click(function(){
            codCategoria = $(this).attr("abrir_categoria");
            nomeCategoria = $(this).text();
            $.ajax({
                url:"src/vendas/produtos.php",
                type:"POST",
                data:{
                    codCategoria,
                    nomeCategoria,
                },
                success:function(dados){
                    $("#home-compras").removeClass("active");
                    $("#home-produtos").addClass("active");
                    $(".produtos_lista").html(dados);
                }
            });
        });


    })
</script>
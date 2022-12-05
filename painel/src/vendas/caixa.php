<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

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
    <div class="row categorias_list"></div>
</div>
<div class="p-3" style="position:fixed; left:0px; top:235px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div class="col-md-6 produtos_lista"></div>

        <div class="col-md-6"></div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');

        $.ajax({
            url:"src/vendas/categorias.php",
            success:function(dados){
                $(".categorias_list").html(dados);
            }
        });

        $.ajax({
            url:"src/vendas/produtos.php",
            success:function(dados){
                $(".produtos_lista").html(dados);
            }
        });

    })
</script>
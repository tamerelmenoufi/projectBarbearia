<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>

<style>

</style>

<div style="padding:20px;">
    <div class="row">
        <div class="col">
            <div class="card p-1" vendasProducao></div>
        </div>
    </div>
</div>


<script>
    $(function(){

        Carregando('none');
        $.ajax({
            url:"src/dashboard/vendas/producao.php",
            success:function(dados){
                $("div[vendasProducao]").html(dados);
            }
        });

    })
</script>
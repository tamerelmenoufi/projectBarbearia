<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>

<style>

</style>

<div style="padding:20px;">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-1" vendasProducao></div>
        </div>
        <div class="col-md-6">
            <div class="card p-1" agendaDia></div>
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

        $.ajax({
            url:"src/dashboard/calendario/agenda_dia.php",
            success:function(dados){
                $("div[agendaDia]").html(dados);
            }
        });


    })
</script>
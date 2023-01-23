<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>

<style>
    .element {
        height:350px;
        overflow:auto;
        width:100%;
        clear:both;
        scrollbar-width: thin;
        scrollbar-color: black transparent;
    }

    .element::-webkit-scrollbar {
        width: 8px;
        height: 5px; /* A altura só é vista quando a rolagem é horizontal */
    }

    .element::-webkit-scrollbar-track {
        background: transparent;
        padding: 2px;
    }

    .element::-webkit-scrollbar-thumb {
        background-color: #ccc;
    }
</style>

<div style="padding:20px;">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-1 mb-3 element" vendasProducao></div>
        </div>
        <div class="col-md-6">
            <div class="card p-1 mb-3 element" agendaDia></div>
        </div>
    </div>
</div>

<div style="padding:20px;">
    <div class="row">
        <div class="col-md-12">
            <div class="p-1 mb-3" vendasRelatorios></div>
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

        $.ajax({
            url:"src/dashboard/vendas/relatorios.php",
            success:function(dados){
                $("div[vendasRelatorios]").html(dados);
            }
        });


    })
</script>
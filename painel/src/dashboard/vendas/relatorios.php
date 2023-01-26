<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .relatorio{
        cursor: pointer;
    }
</style>
<h6>Relatórios Gerais</h6>
<!-- <ul class="list-group">
    <li class="list-group-item relatorio p-3">Total de agendas</li>
    <li class="list-group-item relatorio p-3">Agendas atendidas</li>
    <li class="list-group-item relatorio p-3">Agendas não atendidas</li>
    <li class="list-group-item relatorio p-3">Total de vendas</li>
    <li class="list-group-item relatorio p-3">Vendas por serviços</li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3">Estatísticas dos produtos</li>
</ul> -->

<div class="accordion accordion-flush" id="accordionFlushExample">

    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Total de Agendas</div>
            <div class="col text-end">232</div>
        </div>
    </div>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Agendas Atendidas</div>
            <div class="col text-end">232</div>
        </div>
    </div>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Agendas não Atendidas</div>
            <div class="col text-end">232</div>
        </div>
    </div>

    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Total de vendas</div>
            <div class="col text-end">232</div>
        </div>
    </div>





    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-venda_servico">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-venda_servico" aria-expanded="false" aria-controls="flush-venda_servico">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Vendas por serviços</div>
                <div class="col text-end">232</div>
            </div>

        </button>
        </h2>
        <div id="flush-venda_servico" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-vendas_produtos">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-vendas_produtos" aria-expanded="false" aria-controls="flush-vendas_produtos">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Vendas por produtos</div>
                <div class="col text-end">232</div>
            </div>

        </button>
        </h2>
        <div id="flush-vendas_produtos" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
        </div>
    </div>


    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-vendas_colaborador">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-vendas_colaborador" aria-expanded="false" aria-controls="flush-vendas_colaborador">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Vendas por colaborador</div>
                <div class="col text-end">232</div>
            </div>

        </button>
        </h2>
        <div id="flush-vendas_colaborador" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
        </div>
    </div>




    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Financeiro Bruto</div>
            <div class="col text-end">232</div>
        </div>
    </div>

    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Financeiro comissão</div>
            <div class="col text-end">232</div>
        </div>
    </div>


    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-comissao_colaborador">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-comissao_colaborador" aria-expanded="false" aria-controls="flush-comissao_colaborador">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Comissão por colaborador</div>
                <div class="col text-end">232</div>
            </div>

        </button>
        </h2>
        <div id="flush-comissao_colaborador" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
        </div>
    </div>


</div>


<script>
    $(function(){
        $(".relatorio").click(function(){
            $.alert('<center>Relatório não especificado,<br>aguardando informações!</center>');
        })
    })
</script>
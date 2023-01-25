<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .relatorio{
        cursor: pointer;
    }
</style>
<h6>Relatórios Gerais</h6>
<ul class="list-group">
  <li class="list-group-item relatorio p-3">Vendas Realizadas</li>
  <li class="list-group-item relatorio">Vendas por colaborador</li>
  <li class="list-group-item relatorio">Clientes Cadastrados</li>
  <li class="list-group-item relatorio">Vendas por produtos</li>
  <li class="list-group-item relatorio">Mapa de vendas</li>
  <li class="list-group-item relatorio">Mapa das Agendas</li>
  <li class="list-group-item relatorio">Agendas anuladas</li>
  <li class="list-group-item relatorio">Agendas Canceladas </li>
  <li class="list-group-item relatorio">Vendas Canceladas </li>
  <li class="list-group-item relatorio">Produtos Cadastrados </li>
  <li class="list-group-item relatorio">Estoque de produtos</li>
  <li class="list-group-item relatorio p-3">Estatísticas dos produtos</li>
</ul>



<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
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
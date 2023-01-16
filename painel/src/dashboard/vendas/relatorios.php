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
  <li class="list-group-item relatorio">Vendas Realizadas</li>
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
  <li class="list-group-item relatorio">Estatísticas dos produtos</li>
</ul>

<script>
    $(function(){
        $(".relatorio").click(function(){
            $.alert('<center>Relatório não especificado,<br>aguardando informações!</center>');
        })
    })
</script>
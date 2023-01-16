<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<h6>Relatórios Gerais</h6>
<ul class="list-group">
  <li class="list-group-item relatorio">Vendas Realizadas</li>
  <li class="list-group-item relatorio">Vendas por colaborador</li>
  <li class="list-group-item relatorio">Clientes Cadastrados</li>
  <li class="list-group-item relatorio">Vendas por produtos</li>
  <li class="list-group-item relatorio">Mapa de vendas</li>
</ul>

<script>
    $(function(){
        $(".relatorio").click(function(){
            $.alert('Relatório não especificado, aguardando informações!');
        })
    })
</script>
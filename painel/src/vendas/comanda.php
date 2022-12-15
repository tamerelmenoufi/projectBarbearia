<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel','codVenda']);


    $v = mysqli_fetch_object(mysqli_query($con, "select * from vendas where codigo = '{$_SESSION['codVenda']}'"));
?>

<!-- <ul class="list-group">

<li class="list-group-item"> -->

<div class="row justify-content-between">
  <div class="col-2">
    Cod
  </div>
  <div class="col-4">
    Descrição
  </div>
  <div class="col-2">
    Vl Uni
  </div>
  <div class="col-2">
    Quant.
  </div>
  <div class="col-2">
    Vl Tot
  </div>
</div>

<?php
    $query = "select
                            a.*,
                            p.tipo,
                            p.codigo as cod_produto,
                            p.produto as produto_nome,
                            if(p.tipo = 'p', 'Produto', 'Serviço') as tipo_nome,
                            c.categoria as categoria_nome
                        from vendas_produtos a
                            left join produtos p on a.produto = p.codigo
                            left join produtos_categorias c on p.categoria = c.codigo
                        where a.venda = '{$_SESSION['codVenda']}'";
            $result = mysqli_query($con, $query);
            $n = mysqli_num_rows($result);
            $valor = $comissao = 0;
            $tipo_produtos = false;
            while($d = mysqli_fetch_object($result)){
?>


<div class="row justify-content-between">
  <div class="col-2">

  </div>
  <div class="col-10">
    <b><?=$d->produto_nome?></b><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small>
  </div>
</div>

<div class="row justify-content-between b-3">
  <div class="col-2">
    <?=$d->cod_produto?>
  </div>
  <div class="col-4">

  </div>
  <div class="col-2">
    R$ <?=number_format($v->valor_unitario,2,',','.')?>
  </div>
  <div class="col-2">
    <?=$d->quantidade?>
  </div>
  <div class="col-2">
    R$ <?=number_format($v->valor,2,',','.')?>
  </div>
</div>

<?php
            }
?>

<div class="row justify-content-between">
  <div class="col-10">
    <b>TOTAL</b>
  </div>

  <div class="col-2">
    <b>R$ <?=number_format($v->total,2,',','.')?></b>
  </div>
</div>


  <!-- </li>
</ul> -->

<script>
    $(function(){

        Carregando('none');

    })
</script>
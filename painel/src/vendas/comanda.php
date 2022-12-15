<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel','codVenda']);


    $v = mysqli_fetch_object(mysqli_query($con, "select * from vendas where codigo = '{$_SESSION['codVenda']}'"));
?>

<!-- <ul class="list-group">

<li class="list-group-item"> -->
<div class="p-3">
    <div class="row justify-content-between" style="margin-bottom:10px;">
    <div class="col-2">
        <b>Cod</b>
    </div>
    <div class="col-4">
        <b>Descrição</b>
    </div>
    <div class="col-2">
        <b>Vl Uni</b>
    </div>
    <div class="col-2">
        <b>Quant.</b>
    </div>
    <div class="col-2">
        <b>Vl Tot</b>
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
                    if($d->tipo == 'p') $tipo_produtos = true;
    ?>


    <div class="row justify-content-between">
    <div class="col-2">

    </div>
    <div class="col-10">
        <?=$d->produto_nome?><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small>
    </div>
    </div>

    <div class="row justify-content-between" style="margin-bottom:20px;">
    <div class="col-2">
        <?=$d->cod_produto?>
    </div>
    <div class="col-4">

    </div>
    <div class="col-2">
        R$ <?=number_format($d->valor_unitario,2,',','.')?>
    </div>
    <div class="col-2">
        <?=$d->quantidade?>
    </div>
    <div class="col-2">
        R$ <?=number_format($d->valor,2,',','.')?>
    </div>
    </div>

    <?php
                }
    ?>

    <div class="row justify-content-between" style="margin-top:10px;">
        <div class="col-10 text-end">
            VALOR
        </div>

        <div class="col-2">
            R$ <?=number_format($v->valor,2,',','.')?>
        </div>
    </div>
    <?php
    if($tipo_produtos){
    ?>
    <div class="row justify-content-between">
        <div class="col-10 text-end">
            ENTREGA
        </div>

        <div class="col-2">
            R$ <?=number_format($v->taxa_entrega,2,',','.')?>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="row justify-content-between">
        <div class="col-10 text-end">
            ACRESCIMO
        </div>

        <div class="col-2">
            R$ <?=number_format($v->acrescimo,2,',','.')?>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-10 text-end">
            DESCONTO
        </div>

        <div class="col-2">
            R$ <?=number_format($v->desconto,2,',','.')?>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-10 text-end">
            <b>TOTAL</b>
        </div>

        <div class="col-2">
            <b>R$ <?=number_format($v->total,2,',','.')?></b>
        </div>
    </div>

</div>

  <!-- </li>
</ul> -->

<script>
    $(function(){

        Carregando('none');

    })
</script>
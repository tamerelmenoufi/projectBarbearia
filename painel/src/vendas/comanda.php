<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel','codVenda']);


    // $v = mysqli_fetch_object(mysqli_query($con, "select * from vendas where codigo = '{$_SESSION['codVenda']}'"));


    $query = "select a.*,
                        concat(
                                b.rua, if(b.numero != '',', ',''),
                                b.numero, if(b.bairro != '',', ',''),
                                b.bairro, if(b.cep != '',', ',''),
                                b.cep, if(b.complemento != '',', ',''),
                                b.complemento, if(b.referencia != '',', ',''),
                                b.referencia
                            ) as endereco
                from vendas a
                     left join clientes_enderecos b on a.local_entrega = b.codigo
                where a.codigo = '{$_SESSION['codVenda']}'";
    $result = mysqli_query($con, $query);
    $v = mysqli_fetch_object($result);

?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>

<h4 class="Titulo<?=$md5?>"><i class="fa-solid fa-receipt"></i> Comanda da compra</h4>
<div class="p-3" style="font-size:12px;">
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
            <?=$d->cod_produto?>
        </div>
        <div class="col-10">
            <?=$d->produto_nome?><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small>
        </div>
    </div>

    <div class="row justify-content-between" style="margin-bottom:20px;">
        <div class="col-2">

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

<ul class="list-group mt-3 mb-3">
    <li class="list-group-item">
        <h5>Formas de pagamento</h5>
        <div class="row">
            <div class="col-md-6 mb-2">
                <select class="form-select form-select-sm" id="forma_pagamento">
                    <option value="dinheiro">Dinheiro</option>
                    <option value="pix">PIX</option>
                    <option value="credito">Crédito</option>
                    <option value="debito">Débito</option>
                </select>
            </div>
            <div class="col-md-6 mb-2">

                <div class="input-group input-group-sm">
                    <span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
                    <input type="text" data-thousands="" data-decimal="." id="valor_add" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    <button class="btn btn-success btn-sm"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                </div>

            </div>

        </div>
    </li>
</ul>

    <p style="text-align:center; font-size:12px; color:#a1a1a1;">A compra será entregue para: <b><?=$_SESSION['ClienteAtivoNome']?></b> <?=(($v->local_entrega)?"({$v->endereco})":false)?></p>
</div>



<script>
    $(function(){

        Carregando('none');

    })
</script>
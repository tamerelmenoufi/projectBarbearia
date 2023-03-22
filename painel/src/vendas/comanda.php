<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel','codVenda']);

    if($_POST['acao'] == 'forma_pagamento'){
        $query = "insert into vendas_pagamentos set
                                venda = '{$_SESSION['codVenda']}',
                                colaborador = '{$_SESSION['ProjectPainel']->codigo}',
                                forma_pagamento = '{$_POST['forma_pagamento']}',
                                valor = '{$_POST['valor']}'";
        mysqli_query($con, $query);
    }

    if($_POST['acao'] == 'pagamento_del'){
        $query = "delete from vendas_pagamentos where codigo = '{$_POST['codigo']}' ";
        mysqli_query($con, $query);
    }


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

    $total = ($v->valor + $v->taxa_entrega + $v->acrescimo - $v->desconto);

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
                                c.categoria as categoria_nome,
                                d.nome as nome_colaborador
                            from vendas_produtos a
                                left join produtos p on a.produto = p.codigo
                                left join produtos_categorias c on p.categoria = c.codigo
                                left join colaboradores d on a.colaborador = d.codigo
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
            <?=$d->produto_nome?> <?=(($d->nome_colaborador)?' ('.$d->nome_colaborador.') ':false)?><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small>
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
            <?=(($v->tipo_acrescimo == 'v')?'R$ ':false)?>
            <?=number_format($v->acrescimo,2,',','.')?>
            <?=(($v->tipo_acrescimo == 'p')?'%':false)?>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-10 text-end">
            DESCONTO
        </div>

        <div class="col-2">
            <?=(($v->tipo_desconto == 'v')?'R$ ':false)?>
            <?=number_format($v->desconto,2,',','.')?>
            <?=(($v->tipo_desconto == 'p')?'%':false)?>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-10 text-end">
            <b>TOTAL</b>
        </div>

        <div class="col-2">
            <b>R$ <?=number_format($total,2,',','.')?></b>
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
                        <button class="btn btn-warning btn-sm valor_resto" valor=""></button>
                        <span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
                        <input type="text" data-thousands="" data-decimal="." id="valor_add" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        <button class="btn btn-success btn-sm valor_add"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                    </div>

                </div>

            </div>
            <ul class="list-group">
            <?php
            $query = "select * from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'";
            $result = mysqli_query($con, $query);
            $resto = 0;
            $nPagamento = 0;
            while($p = mysqli_fetch_object($result)){
                $nPagamento = ($nPagamento*1 + $p->valor*1);
            ?>
            <li class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col"><?=$p->forma_pagamento?></div>
                    <div class="col text-end">R$ <?=number_format($p->valor,2,',','.')?></div>
                    <div class="col text-end">
                        <button class="btn btn-danger btn-sm pagamento_del" cod="<?=$p->codigo?>"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </li>
            <?php
            }
            $resto = number_format(($total - $nPagamento),2,'.',false);
            ?>
            </ul>

        </li>
    </ul>

    <div class="row mt-3 mb-3">
        <?php
        if($v->local_entrega || $v->entrega_estabelecimento){
        ?>
        <!-- <div class="col d-grid">
            <button class="btn btn-warning btn-sm" <?=((!$nPagamento)?'disabled':false)?>><i class="fa-solid fa-motorcycle"></i> Solicitar Entrega</button>
        </div> -->
        <?php
        }
        ?>
        <div class="col d-grid">
            <button class="btn btn-primary btn-sm"  <?=(($resto == 0)?'concluir_venda':'disabled')?>><i class="fa-regular fa-circle-check"></i> Concluir</button>
        </div>
    </div>

    <p style="text-align:center; font-size:12px; color:#a1a1a1;">Atendimento / Pedido para: <b><?=$_SESSION['ClienteAtivoNome']?></b> <?=(($v->local_entrega)?"({$v->endereco})":(($v->retirada_estabelecimento)?' (Retirada no estabelecimento)':false))?></p>
</div>



<script>
    $(function(){

        Carregando('none');

        $('#valor_add').maskMoney();

        <?php
        if(!($resto*1)){
        ?>
        $('#forma_pagamento').attr("disabled","disabled");
        $('#valor_add').attr("disabled","disabled");
        $('.valor_add').attr("disabled","disabled");
        $(".valor_resto").remove();
        <?php
        }else{
        ?>
        $(".valor_resto").html('R$ <?=number_format($resto,2,',','.')?>');
        $(".valor_resto").attr("valor",'<?=$resto?>');
        $(".valor_resto").click(function(){
            valor = $(this).attr("valor");
            $('#valor_add').val(valor);
        });
        <?php
        }
        ?>

        $(".valor_add").click(function(){
            total = <?=$total?>;
            resto = <?=$resto?>;
            valor = $('#valor_add').val();
            forma_pagamento = $('#forma_pagamento').val();
            console.log(`${valor} > ${total} || ${valor} > ${resto}`);
            if( (valor*1) > (total*1) || (valor*1) > (resto*1)){
                $.alert('O valor pago não pode ser superior ao valor da compra!')
                return false;
            }
            if(!(valor*1)) return false;
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    valor,
                    forma_pagamento,
                    acao:'forma_pagamento',
                },
                url:"src/vendas/comanda.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })



        $(".pagamento_del").click(function(){

            codigo = $(this).attr("cod");
            forma_pagamento = $('#forma_pagamento').val();
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    codigo,
                    acao:'pagamento_del',
                },
                url:"src/vendas/comanda.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })

        //TESTE

        $("button[concluir_venda]").click(function(){

            $.confirm({
                content:"Esta operação finaliza a sua compra.<br><b>Deseja Realmente Confirmar?</b>",
                title:"Finalização da Compra",
                buttons:{
                    'SIM':{
                        text:'<i class="fa-solid fa-check"></i> Confirmo',
                        btnClass:'btn btn-success btn-sm',
                        action:function(){
                            Carregando();
                            $.ajax({
                                type:"POST",
                                data:{
                                    acao:'fechar_pedido',
                                },
                                url:"src/vendas/caixa.php",
                                success:function(dados){
                                    console.log("MEUS DADOS DE FECHAR PEDIDO");
                                    console.log(dados);
                                    $.ajax({
                                        url:"src/dashboard/index.php",
                                        success:function(dados){
                                            $("#paginaHome").html(dados);
                                        }
                                    });

                                }
                            });
                            let myOffCanvas = document.getElementById('offcanvasDireita');
                            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                            openedCanvas.hide();
                        }
                    },
                    'NÃO':{
                        text:'<i class="fa-solid fa-xmark"></i> Cancelar',
                        btnClass:'btn btn-danger btn-sm',
                        action:function(){

                        }
                    }
                }
            });



        });


    })
</script>
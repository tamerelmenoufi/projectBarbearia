<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel']);

    if($_POST['acao'] == 'forma_pagamento'){
        $query = "insert into vendas_pagamentos set
                                venda = '{$_POST['comanda']}',
                                colaborador = '{$_SESSION['ProjectPainel']->codigo}',
                                forma_pagamento = '{$_POST['forma_pagamento']}',
                                valor = '{$_POST['valor']}'";
        mysqli_query($con, $query);
    }

    if($_POST['acao'] == 'pagamento_del'){
        $query = "delete from vendas_pagamentos where codigo = '{$_POST['codigo']}' ";
        mysqli_query($con, $query);
    }


    // $v = mysqli_fetch_object(mysqli_query($con, "select * from vendas where codigo = '{$_POST['comanda']}'"));


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
                where a.codigo = '{$_POST['comanda']}'";
    $result = mysqli_query($con, $query);
    $v = mysqli_fetch_object($result);

    // $total = ($v->valor + $v->taxa_entrega + $v->acrescimo - $v->desconto);

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
                            where a.venda = '{$_POST['comanda']}'";
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
            ACRESCIMO <?=(($v->tipo_acrescimo == 'p')?' ('.number_format($v->acrescimo,2,',','.').'%)':false)?>
        </div>

        <div class="col-2">
            <?=(($v->tipo_acrescimo == 'v')?'R$ '.number_format($v->acrescimo,2,',','.'):false)?>
            <?=(($v->tipo_acrescimo == 'p')?'R$ '.(number_format(($v->valor/100*$v->acrescimo),2,',','.')):false)?>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-10 text-end">
            DESCONTO <?=(($v->tipo_desconto == 'p')?' ('.number_format($v->desconto,2,',','.').'%)':false)?>
        </div>

        <div class="col-2">
            <?=(($v->tipo_desconto == 'v')?'R$ '.number_format($v->desconto,2,',','.'):false)?>
            <?=(($v->tipo_desconto == 'p')?'R$ '.(number_format(($v->valor/100*$v->desconto),2,',','.')):false)?>
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

            <div class="text-end m-2">
                <b><i>Formas de pagamento</i></b>
            </div>

            <?php
            $query = "select * from vendas_pagamentos where venda = '{$_POST['comanda']}'";
            $result = mysqli_query($con, $query);
            $resto = 0;
            $nPagamento = 0;
            while($p = mysqli_fetch_object($result)){
                $nPagamento = ($nPagamento*1 + $p->valor*1);
            ?>

            <div class="row justify-content-between">
                <div class="col-10 text-end">
                <?=strtoupper($p->forma_pagamento)?>
                </div>

                <div class="col-2">
                    R$ <?=number_format($p->valor,2,',','.')?>
                </div>
            </div>

            <?php
            }
            if(trim($d->observacoes)){
            ?>


    <div class="row mt-3 mb-3">
        <div class="form-control"><?=$d->observacoes?></div>
    </div>
            <?php
            }
            ?>

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
            total = <?=$v->total?>;
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

            observacoes = $("#observacoes").val();

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
                                    observacoes,
                                },
                                url:"src/vendas/caixa.php",
                                success:function(dados){
                                    // console.log("MEUS DADOS DE FECHAR PEDIDO");
                                    // console.log(dados);
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
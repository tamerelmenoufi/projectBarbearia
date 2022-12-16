<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    error_reporting(9);

    $query = "select
                    a.venda,
                    sum(a.valor_total) as total,
                    b.nome,
                    b.cpf,
                    b.telefone,
                    b.email,
                    c.cep,
                    c.numero,
                    c.rua, bairro
                from vendas_produtos a
                    left join clientes b on a.cliente = b.codigo
                where a.venda = '{$_SESSION['AppVenda']}' and a.deletado != '1'";

    $query = "select
                    a.*,
                    d.id as id_loja,
                    b.nome,
                    b.cpf,
                    b.telefone,
                    b.email,
                    c.cep,
                    c.numero,
                    c.rua, bairro
                from vendas a
                     left join clientes b on a.cliente = b.codigo
                     left join clientes_enderecos c on c.cliente = b.codigo and c.padrao = '1'
                     left join lojas d on a.loja = d.codigo
                where a.codigo = '{$_SESSION['AppVenda']}'";

    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $pos =  strripos($d->nome, " ");

?>
<style>
    .PedidoTopoTitulo{
        position:fixed;
        left:0px;
        top:0px;
        width:100%;
        height:60px;
        background:#f5ebdc;
        padding-left:70px;
        padding-top:15px;
        z-index:1;
    }
    .card small{
        font-size:12px;
        text-align:left;
    }
    .card input{
        border:solid 1px #ccc;
        border-radius:3px;
        background-color:#eee;
        color:#333;
        font-size:20px;
        text-align:center;
        margin-bottom:15px;
        width:100%;
        text-transform:uppercase;
    }
    .status_pagamento{
        width:100%;
        text-align:center;
    }
</style>
<div class="PedidoTopoTitulo">
    <h4>Pagar com PIX</h4>
</div>
<div class="col">
    <div class="row">
            <div class="col-12">
                <div class="card mb-3" style="background-color:#fafcff; padding:20px;">
                    <p style="text-align:center">
                        <?php

                            $pedido = str_pad($d->codigo, 6, "0", STR_PAD_LEFT);


                            $PIX = new MercadoPago;
                            $retorno = $PIX->ObterPagamento($d->operadora_id);
                            $operadora_retorno = $retorno;
                            $dados = json_decode($retorno);

                            if( $d->operadora_id and
                                $d->operadora == 'mercadopago' and
                                $d->total == $dados->transaction_amount
                                ){

                                // echo "<pre>";
                                // print_r($dados);
                                // echo "</pre>";

                                $operadora_id = $dados->id;
                                $forma_pagamento = $dados->payment_method_id;
                                $operadora_situacao = $dados->status;
                                $qrcode = $dados->point_of_interaction->transaction_data->qr_code;
                                $qrcode_img = $dados->point_of_interaction->transaction_data->qr_code_base64;

                            }else{
                                //ESSAS DUAS LINHAS SÃO PARA A SOLICITAÇÃO DA ENTREGA BEE
                                // $BEE = new Bee;
                                // echo $retorno = $BEE->NovaEntrega($d->codigo);
                                //////////////////////////////////////////////////////////

                                //AQUI É A GERAÇÃO DA COBRANÇA PIX

                                $PIX = new MercadoPago;
                                // "transaction_amount": '.$d->total.',
                                // "transaction_amount": 2.11,
                                $retorno = $PIX->Transacao('{
                                    "transaction_amount": '.$d->total.',
                                    "description": "Pedido '.$pedido.' - Venda BKManaus (Delivery)",
                                    "payment_method_id": "pix",
                                    "payer": {
                                    "email": "'.$d->email.'",
                                    "first_name": "'.substr($d->nome, 0, ($pos-1)).'",
                                    "last_name": "'.substr($d->nome, $pos, strlen($d->nome)).'",
                                    "identification": {
                                        "type": "CPF",
                                        "number": "'.str_replace(array('.','-'),false,$d->cpf).'"
                                    },
                                    "address": {
                                        "zip_code": "'.str_replace(array('.','-'),false,$d->cep).'",
                                        "street_name": "'.$d->rua.'",
                                        "street_number": "'.$d->numero.'",
                                        "neighborhood": "'.$d->bairro.'",
                                        "city": "Manaus",
                                        "federal_unit": "AM"
                                    }
                                    }
                                }');

                                $dados = json_decode($retorno);

                                $operadora_id = $dados->id;
                                $forma_pagamento = $dados->payment_method_id;
                                $operadora_situacao = $dados->status;
                                $qrcode = $dados->point_of_interaction->transaction_data->qr_code;
                                $qrcode_img = $dados->point_of_interaction->transaction_data->qr_code_base64;


                                if($operadora_id){

                                    //////////////////////API DELIVERY////////////////////////////

                                    $content = http_build_query(array(
                                        'pedido' => $d->codigo,
                                        'empresa' => $d->id_loja,
                                    ));

                                    $context = stream_context_create(array(
                                        'http' => array(
                                            'method'  => 'POST',
                                            'content' => $content,
                                            'header' => "Content-Type: application/x-www-form-urlencoded",
                                        )
                                    ));

                                    $result = file_get_contents("http://bee.mohatron.com/pedido.php", null, $context);
                                    $result = json_decode($result);
                                    $api_delivery = $result->codigo;


                                    //////////////////////API DELIVERY////////////////////////////


                                    $q = "insert into status_venda set
                                    venda = '{$d->codigo}',
                                    operadora = 'mercado_pago',
                                    tipo = 'pix',
                                    data = NOW(),
                                    retorno = '{$retorno}'";
                                    mysqli_query($con, $q);

                                    mysqli_query($con, "update vendas set
                                                                operadora_id = '{$operadora_id}',
                                                                forma_pagamento = '{$forma_pagamento}',
                                                                operadora = 'mercadopago',
                                                                operadora_situacao = '{$operadora_situacao}',
                                                                operadora_retorno = '{$retorno}',
                                                                api_delivery = '{$api_delivery}'
                                                        where codigo = '{$d->codigo}'
                                                ");

                                }
                            }

                            // $qrcode = '12e44a26-e3b4-445f-a799-1199df32fa1e';
                            // $operadora_id = 23997683882;

                        ?>
                        Utilize o QrCode para pagar a sua conta ou copie o códio PIX abaixo.
                    </p>
                    <div style="padding:20px;">
                        <img src="data:image/png;base64,<?=$qrcode_img?>" style="width:100%">
                        <!-- <img src="img/qrteste.png" style="width:100%"> -->
                        <div class="status_pagamento"></div>
                    </div>
                    Total a Pagar:
                    <h1>R$ <?=number_format($d->total,2,',','.')?></h1>
                    <p style="text-align:center; font-size:12px;">Clique no botão abaixo para copiar o Código PIX de sua compra.</p>
                    <!-- <p style="text-align:center; font-size:16px;"><?=$qrcode?></p> -->
                    <button copiar="<?=$qrcode?>" class="btn btn-secondary btn-lg btn-block"><i class="fa-solid fa-copy"></i> <span>Copiar Código PIX</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){

        $("button[copiar]").click(function(){
            obj = $(this);
            texto = $(this).attr("copiar");
            CopyMemory(texto);
            obj.removeClass('btn-secondary');
            obj.addClass('btn-success');
            obj.children("span").text("Código PIX Copiado!");
        });

        <?php
        if($operadora_id){
        ?>
        $.ajax({
            url:"src/produtos/pagar_pix_verificar.php",
            type:"POST",
            data:{
                id:'<?=$operadora_id?>'
            },
            success:function(dados){
                $(".status_pagamento").html(dados)
            }
        });
        <?php
        }
        ?>
    })
</script>
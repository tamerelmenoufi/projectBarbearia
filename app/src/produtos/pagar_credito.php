<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'pagar'){

        //////////////////////API DELIVERY////////////////////////////

        $content = http_build_query(array(
            'pedido' => $_POST['reference'],
            'empresa' => $_POST['loja'],
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
        if($_SESSION["palavra"] == $_POST['captcha']){

            require "../../../lib/vendor/rede/Transacao.php";

            $query = "insert into status_venda set
                                                venda = '{$_POST['reference']}',
                                                operadora = 'rede',
                                                tipo = 'credito',
                                                data = NOW(),
                                                retorno = '{$retorno}'";
            mysqli_query($con, $query);

            require "../../../lib/vendor/rede/Consulta.php";
            $r = json_decode($retorno);

            $query = "update vendas set

                                        operadora = 'rede',
                                        operadora_situacao = '{$r->authorization->status}',
                                        operadora_retorno = '{$retorno}',
                                        /*valor = '{$_POST['amount']}',
                                        taxa = '{$_POST['taxa']}',
                                        desconto = '{$_POST['desconto']}',
                                        acrescimo = '{$_POST['acrescimo']}',
                                        total = '".($_POST['amount'] + $_POST['taxa'] + $_POST['taxa_entrega'] - $_POST['desconto'] + $_POST['acrescimo'])."',
                                        observacoes = '{$_POST['observacoes']}',*/
                                        data_finalizacao = NOW(),
                                        api_delivery = '{$api_delivery}',
                                        ".(($r->authorization->status == 'Approved')?"situacao = 'p',":false)."
                                        forma_pagamento = 'credito'

                    where codigo = '{$_POST['reference']}'";
            mysqli_query($con, $query);

            if($r->authorization->status == 'Approved'){
                //mysqli_query($con, "INSERT INTO vendas SET cliente = '{$_SESSION['AppCliente']}', mesa = '{$_SESSION['AppPedido']}'");
                $_SESSION['AppVenda'] = false; //mysqli_insert_id($con);
                $_SESSION['AppPedido'] = false;
                $_SESSION['AppCarrinho'] = false;
                echo json_encode([
                    'status' => $r->authorization->status,
                    'msg' => 'Operação realizada com sucesso!',
                    //'AppVenda' => $_SESSION['AppVenda'],
                ]);
            }else if($r->authorization->status == 'Denied')
            {
                echo json_encode([
                    'status' => $r->authorization->status,
                    'msg' => 'Operação Negada, consulte os dados do Cartão ou entre em contato com sua operadora!',
                    //'AppVenda' => $_SESSION['AppVenda'],
                ]);
            }else{
                echo json_encode([
                    'status' => false,
                    'msg' => 'Ocorreu um erro, tente novamente!',
                    //'AppVenda' => $_SESSION['AppVenda'],
                ]);
                //Dados de teste
            }
            mysqli_query($con, "update vendas set tentativas_pagamento = (tentativas_pagamento -1) where codigo = '{$_POST['reference']}'");
        }else{
                echo json_encode([
                    'status' => false,
                    'msg' => 'Capcha não identificado, favor tente novamente!',
                    //'AppVenda' => $_SESSION['AppVenda'],
                ]);
        }

        exit();
    }

    $query = "select
                    sum(a.valor_total) as total,
                    b.nome,
                    b.telefone
                from vendas_produtos a
                    left join clientes b on a.cliente = b.codigo
                where a.venda = '{$_SESSION['AppVenda']}' and a.deletado != '1'";

    $query = "select a.*, b.id as id_loja from vendas a left join lojas b on a.loja = b.codigo where a.codigo = '{$_SESSION['AppVenda']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

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

    .alertas{
        width:100%;
        text-align:center;
        background-color:#ffffff;
        border:solid 1px #fd3e00;
        color:#ff7d52;
        text-align:center !important;
        border-radius:7px;
        font-size:11px !important;
        font-weight:normal !important;
        padding:5px;
        margin-top:10px;
        margin-bottom:10px;
        display:<?=(($d->tentativas_pagamento < 3)?'block':'none')?>;
    }

</style>
<div class="PedidoTopoTitulo">
    <h4>Pagar <?=$_SESSION['AppPedido']?> com Crédito</h4>
</div>
<div class="col" style="margin-bottom:60px;">
    <div class="row">
            <div class="col-12">
                <div class="card text-white bg-danger mb-3" style="padding:20px;">

                    <small>Nome</small>
                    <input type="text" id="cartao_nome" placeholder="NOME NO CARTÃO" value='' />
                    <small>Número</small>
                    <input inputmode="numeric" maxlength='19' type="text" id="cartao_numero" placeholder="0000 0000 0000 0000" value='' />
                    <div class="row">
                        <div class="col-4">
                            <small>BANDEIRAS</small>
                            <div class="row">
                                <div class="col">
                                    <h2>
                                        <i class="fa-brands fa-cc-mastercard"></i>
                                    </h2>
                                </div>
                                <div class="col">
                                    <h2>
                                        <i class="fa-brands fa-cc-visa"></i>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <small>MM</small>
                            <input inputmode="numeric" maxlength='2' type="text" id="cartao_validade_mes" placeholder="00" value='' />
                        </div>
                        <div class="col-3">
                            <small>AAAA</small>
                            <input inputmode="numeric" maxlength='4' type="text" id="cartao_validade_ano" placeholder="0000" value='' />
                        </div>
                        <div class="col-3">
                            <small>CVV</small>
                            <input inputmode="numeric" maxlength='4' type="text" id="cartao_ccv" placeholder="0000" value='' />
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary btn-block btn-lg" id="Pagar" tentativas="<?=$d->tentativas_pagamento?>" loja="<?=$d->id_loja?>">
                    <i class="fa fa-calculator" aria-hidden="true"></i>
                    PAGAR R$ <?=number_format($d->total, 2, ',','.')?>
                </button>

                <div class="alertas animate__animated animate__fadeIn animate__infinite animate__slower">
                    Atenção, você possui <span tentativa><?=$d->tentativas_pagamento?></span> tentativa(s)!
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#cartao_numero").mask("9999 9999 9999 9999");
        $("#cartao_validade_mes").mask("99");
        $("#cartao_validade_ano").mask("9999");
        $("#cartao_ccv").mask("9999");

        $("#Pagar").click(function(){

            kind = 'credit';
            reference = '<?=$_SESSION['AppVenda']?>';
            amount = '<?=$d->total?>';
            cardholderName = $("#cartao_nome").val();
            cardNumber = $("#cartao_numero").val();
            expirationMonth = $("#cartao_validade_mes").val();
            expirationYear = $("#cartao_validade_ano").val();
            securityCode = $("#cartao_ccv").val();
            tentativas = $(this).attr("tentativas");
            loja = $(this).attr("loja");
            captcha = '<?=$_POST['captcha']?>';

            if(tentativas == 0){
                msg = '<div style="color:red"><center><h2><i class="fa-solid fa-ban"></i></h2>Você passou de três tentativas de pagamento com cartão de crédito. Favor selecionar outra forma de pagamento!</center></div>';
                $.alert(msg);
                return false;
            }

            if(
                    !kind
                ||  !reference
                ||  !amount
                ||  !cardholderName
                ||  !cardNumber
                ||  !expirationMonth
                ||  !expirationYear
                ||  !securityCode

            ){
                $.alert('Preenche os dados do cartão corretamente!');
                return false;
            }

            $.ajax({
                url:"src/produtos/pagar_credito.php",
                type:"POST",
                data:{
                    kind,
                    reference,
                    amount,
                    cardholderName,
                    cardNumber,
                    expirationMonth,
                    expirationYear,
                    securityCode,
                    loja,
                    captcha,
                    acao:'pagar'
                },
                success:function(dados){
                    let retorno = JSON.parse(dados);
                    $.alert(retorno.msg);
                    tentativa = (tentativas*1-1);
                    $("#Pagar").attr("tentativas", tentativa);
                    $(".alertas").css("display","block");
                    $("span[tentativa]").html(tentativa);
                    if (retorno.status == 'Approved') {
                        window.localStorage.removeItem('AppVenda');
                        window.localStorage.removeItem('AppPedido');
                        PageClose(2);
                    }
                }
            });

        });


    })
</script>
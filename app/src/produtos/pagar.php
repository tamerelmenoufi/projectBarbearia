<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");


    if($_POST['acao'] == 'loja'){

        $total = ($_POST['valor'] + $_POST['acrescimo'] + $_POST['taxa'] + $_POST['LjVl'] - $_POST['desconto']);

        if($_POST['LjCd'] > 0){
        $query = "update vendas set
                                    loja = '{$_POST['LjCd']}',
                                    taxa_entrega = '{$_POST['LjVl']}',
                                    taxa = '{$_POST['taxa']}',
                                    desconto = '{$_POST['desconto']}',
                                    acrescimo = '{$_POST['acrescimo']}',
                                    valor = '{$_POST['valor']}',
                                    total = '{$total}'
                where codigo = '{$_SESSION['AppVenda']}'";

        mysqli_query($con, $query);



        #############################################################################
        $content = http_build_query(array(
            'pedido' => $_SESSION['AppVenda'],
            'empresa' => $_POST['LjId'],
        ));

        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'content' => $content,
            )
        ));

        $result = file_get_contents("http://bee.mohatron.com/pedido.php", null, $context);
        #############################################################################

        echo json_encode(VerificarProdutos($_POST['LjCd']));
        // echo json_encode(VerificarProdutos());
        }else{
            echo json_encode(['status' => true]);
        }
        exit();

    }


    VerificarVendaApp();


    $query = "select
                    sum(a.valor_total) as total,
                    b.nome,
                    b.telefone,
                    b.telefone_confirmado,
                    b.loja,
                    a.venda,
                    v.tentativas_pagamento
                from vendas_produtos a
                    left join clientes b on a.cliente = b.codigo
                    left join vendas v on a.venda = v.codigo
                where a.venda = '{$_SESSION['AppVenda']}' and a.deletado != '1'";

    $query = "select
                a.*,
                (select sum(valor_total) from vendas_produtos where venda = a.codigo and deletado != '1') as valor,
                d.id as id_loja,
                b.nome,
                b.cpf,
                b.telefone,
                b.telefone_confirmado,
                b.email,
                c.cep,
                c.numero,
                c.rua,
                c.bairro
            from vendas a
                 left join clientes b on a.cliente = b.codigo
                 left join clientes_enderecos c on c.cliente = b.codigo and c.padrao = '1'
                 left join lojas d on a.loja = d.codigo
            where a.codigo = '{$_SESSION['AppVenda']}'";

    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    if(!$d->valor) $_SESSION['AppCarrinho'] = false;

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
    .card-title small{
        font-size:10px;
    }
    .card-title div{
        width:100%;
        text-align:left;
        font-size:14px;
        font-weight:normal;
    }
    .card-title button[opc]{
        width:100%;
        text-align:left;
    }
    .card-title p{
        width:100%;
        text-align:center;
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
    }

    .SemProduto{
        position:fixed;
        top:40%;
        left:0;
        text-align:center;
        width:100%;
        color:#ccc;
    }
    .icone{
        font-size:70px;
    }
    .alterar_endereco{
        cursor:pointer;
        color:blue;

    }

    /* Frete Grátis */
    .valor_frete{
        text-decoration:line-through;
    }


</style>
<div class="PedidoTopoTitulo">
    <h4>Pagar <?=$_SESSION['AppPedido']?></h4>
</div>

<div class="col" style="margin-bottom:60px; display:<?=(($d->valor)?'block':'none')?>">
    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header"><i class="fa-solid fa-clipboard-list"></i> Dados da Compra</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">
                                <small>Pedido</small>
                                <div style="font-size:18px; color:blue;"><?=str_pad($d->codigo, 6, "0", STR_PAD_LEFT)?></div>
                            </h5>
                        </div>
                        <div class="col-6">
                            <h5 class="card-title">
                                <small>Valor</small>
                                <div style="font-size:20px; color:#502314;">R$ <?=number_format($d->valor,2,',','.')?></div>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title">
                                <small><i class="fa-solid fa-user-check"></i> Cliente</small>
                                <div><?="{$d->nome}<br>{$d->telefone}"?></div>
                                <?php
                                if(!$d->nome or !$d->telefone_confirmado){
                                ?>
                                <div class="alertas animate__animated animate__fadeIn animate__infiniteX animate__fasterX">Dados Incompletos, atualize para fechar o seu pedido.</div>
                                <button class="ConfirmaTelefone btn btn-danger btn-block">Atualizar Cadastro</button>
                                <?php
                                }
                                ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header"><i class="fa-solid fa-location-dot"></i> Endereço para Entrega</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <?php
                                $coordenadas = false;
                                $query1 = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}' and deletado != '1' order by padrao desc limit 1";
                                $result1 = mysqli_query($con, $query1);
                                if(mysqli_num_rows($result1)){
                                $d1 = mysqli_fetch_object($result1);
                                $coordenadas = $d1->coordenadas;
                            ?>

                            <b><?=$d1->nome?></b>
                            <h5 class="card-title">
                                <small><i class="fa-solid fa-map-pin"></i> Endereço</small>
                                <div><?=trim($d1->rua).", ".trim($d1->numero).", ".trim($d1->bairro).
                                (($d1->complemento)?', '.$d1->complemento:false).
                                (($d1->referencia)?', '.$d1->referencia:false)?></div>

                                <?php
                                if(!$coordenadas){
                                ?>
                                <div class="alertas animate__animated animate__fadeIn animate__infiniteX animate__fasterX">Endereço Pendente de validação.</div>
                                <button endereco="<?=$d1->codigo?>" class="ConfirmaEndereco btn btn-danger btn-block">Validar Endereço</button>
                                <?php
                                }
                                ?>



                            </h5>
                            <?php
                            }else{
                            ?>
                            <div class="alertas animate__animated animate__fadeIn animate__infiniteX animate__fasterX">
                                Você não possui endereço cadastrado, utilize o linque abaixo para cadastrar seu(s) endereço(s).
                            </div>
                            <?php
                            }
                            ?>

                            <div style="width:100%; text-align:right; margin-top:20px; margin-bottom:20px;">
                                <span class='alterar_endereco'>
                                    <i class="fa-solid fa-repeat"></i>
                                    Trocar/Cadastrar Endereço
                                </span>
                            </div>


                            <?php
                            if($coordenadas){
                            ?>
                            Taxa de Entrega

                            <div id="accordion">
                                <div class="card">
                                    <div id="headingOne">
                                        <ul class="list-group">
                                            <li class="<?=(($promocao_taxa_zero and $StatusApp == 'a')?'valor_frete':false)?> loja list-group-item d-flex justify-content-between align-items-center list-group-item-info" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <small></small>
                                                <span class="badge badge-pill">
                                                    <small></small>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div id="<?=(($StatusApp == 'a' and !$promocao_taxa_zero)?'collapseOne':false)?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                        <ul class="list-group">
                                        <?php
                                            $bee = new Bee;
                                            list($lat, $lng) = explode(",", $coordenadas);
                                            $q = "select * from lojas where situacao = '1' and online='1' and deletado != '1' and (time(NOW()) between hora_ini and hora_fim)";
                                            $r = mysqli_query($con, $q);
                                            $vlopc = 0;
                                            if(mysqli_num_rows($r)){
                                            while($v = mysqli_fetch_object($r)){

                                                $valores = json_decode($bee->ValorViagem($v->id, $lat, $lng));
                                                if($valores->deliveryFee > 1){

                                                if($valores->deliveryFee <= $vlopc || $vlopc == 0) {
                                                    $vlopc = $valores->deliveryFee;
                                                    $opc = $v->codigo; //Opção mais barata
                                                    // $opc = $d->loja; //Opção de preferência do cliente

                                                }

                                        ?>
                                            <li
                                                opc="<?=$v->codigo?>"
                                                LjId="<?=$v->id?>"
                                                valor="<?=$valores->deliveryFee?>"
                                                class="opcLoja list-group-item d-flex justify-content-between align-items-center">
                                                <small><?=$v->nome?></small>
                                                <span class="badge badge-pill">
                                                    <small>R$ <?=number_format($valores->deliveryFee,2,',','.')?></small>
                                                </span>
                                            </li>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                        </ul>
                                    </div>


                                    <div promocao_frete style="width:100%; text-align:center;bottom margin-top:10px; margin-top:30px;">
                                        <img src="img/promocao_frete_gratis.gif" alt="Promoção Frete Grátis" style="width:100%; border-radius:10px;" />
                                    </div>

                                </div>
                            </div>






                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    if($coordenadas and $d->nome and $d->telefone_confirmado){
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header"><i class="fa-solid fa-receipt"></i> Não Sou Robô</div>
                <div class="card-body">
                    <h5 robo class="card-title" captcha="error">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col">
                                <small>
                                    Digite no campo os números da Iamgem
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="imagemCaptcha col">
                                <img style="border-radius:5px;" src="src/produtos/captcha.php?l=150&a=45&tf=20&ql=5">
                            </div>
                            <div class="col">
                                <input id="captcha" type="text" inputmode="numeric" class="form-control form-control-lg" style="text-align:center; font-weight:bold, font-size:9px;" />
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col atualizarCaptcha">
                                <i class="fa-solid fa-rotate"></i> Atualizar Imagem
                            </div>
                        </div>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>


    <div class="row">
        <div class="col-12">
            <div class="card bg-light mb-3">
                <div class="card-header"><i class="fa-solid fa-receipt"></i> Formas de Pagamento</div>
                <div class="card-body" dadosValores
                            valor = '<?=$d->valor?>'
                            taxa = '0'
                            desconto = '<?=(($promocao_taxa_zero)?$vlopc:0)?>'
                            acrescimo = '0'
                >
                    <?php
                    $pagar = true;
                    if(!$coordenadas or !$d->nome or !$d->telefone_confirmado){
                    ?>
                    <div class="alertas animate__animated animate__fadeIn animate__infiniteX animate__fasterX">
                        Você possui pendências em seu cadastro. Verifique as notificações acima e atualize seu cadastro para concluir seu pedido.
                    </div>
                    <?php
                    $pagar = false;
                    }
                    ?>
                    <!-- <h5 class="card-title">
                        <a pagar opc="debito" class="btn btn-danger btn-lg"><i class="fa-solid fa-credit-card"></i> Débito</a>
                    </h5> -->
                    Total a Pagar:
                    <h1>R$ <?=number_format($d->valor + ((!$promocao_taxa_zero)?$vlopc:0) ,2,',','.')?></h1>
                    <?php
                    if($StatusApp == 'a'){
                    ?>
                    <h5 class="card-title">

                        <button <?=(($pagar)?'pagar':'disabled')?> opc="credito" blq="s" class="btn btn-info btn-lg" tentativas="<?=$d->tentativas_pagamento?>" captcha=""><i class="fa-solid fa-credit-card"></i> Cartão</button>
                    </h5>
                    <h5 class="card-title">
                        <button <?=(($pagar)?'pagar':'disabled')?> opc="pix" blq="s" class="btn btn-info btn-lg" captcha=""><i class="fa-brands fa-pix"></i> PIX</button>
                    </h5>
                    <!-- <h5 class="card-title">
                        <a pagar opc="dinheiro" class="btn btn-danger btn-lg"><i class="fa-solid fa-money-bill-1"></i> Dinheiro</a>
                    </h5> -->
                    <?php
                    }else{
                    ?>
                    <h5 class="card-title">
                    <button disabled class="btn btn-danger btn-lg btn-block"><i class="fa-solid fa-door-closed"></i> LOJA FECHADA</button>
                    </h5>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>



</div>


<div class="SemProduto" style="display:<?=(($d->valor)?'none':'block')?>">
    <i class="fa-solid fa-face-frown icone"></i>
    <p>Poxa, ainda não tem produtos em seu pedido!</p>
</div>


<script>

    $(function(){

        $("#captcha").mask("99999");

        lj = $('li[opc="<?=$opc?>"]');
        dados = lj.html();
        // console.log(dados);
        if(dados && dados != undefined){
            $(".loja").html(dados);
            $('li[opc="<?=$opc?>"]').addClass('list-group-item-info');

            LjVl = lj.attr("valor");
            LjCd = lj.attr("opc");
            LjId = lj.attr("LjId");
            valor = $("div[dadosValores]").attr('valor');
            taxa = $("div[dadosValores]").attr('taxa');
            desconto = $("div[dadosValores]").attr('desconto');
            acrescimo = $("div[dadosValores]").attr('acrescimo');

            $.ajax({
                    url:"src/produtos/pagar.php",
                    type:"POST",
                    dataType:"JSON",
                    data:{
                        LjVl,
                        LjCd,
                        LjId,
                        valor,
                        taxa,
                        desconto,
                        acrescimo,
                        acao:'loja'
                    },
                    success:function(dados){
                        console.log(dados);
                        if(dados.status == false){
                            $("button[blq]").attr("blq",'s');
                            $.alert({
                                content:'<center><h1><i class="fa-solid fa-face-sad-tear" style="font-size:80px; color:#ccc;"></i></h1><p>Infelizmente não iremos poder te atender. Itens de sua cesta de pedidos está em falta.</p><center>',
                                title:false,
                                type:'red',
                                buttons:{
                                    'ok':{
                                        text:'<i class="fa-regular fa-thumbs-up"></i> Entendi',
                                        btnClass:'btn btn-primary',
                                        action:function(){

                                        }
                                    }
                                }
                            })
                        }else{
                            $("button[blq]").attr("blq",'n');
                        }
                    }
            });
        }else{
            $(".loja").html('Lojas indisponíveis para entrega');
            $('.loja').removeClass('list-group-item-info');
            $('.loja').addClass('list-group-item-danger');
        }

        $("#captcha").keyup(function(){
            captcha = $(this).val();
            if(captcha.length == 5){
                $.ajax({
                    url:"src/produtos/captcha.php",
                    data:{
                        captcha,
                        validar:'1'
                    },
                    success:function(dados){
                        if(dados == 'success'){
                            $("#captcha").css("border-color","green");
                            $("h5[robo]").attr("captcha","success");
                            $("h5[robo]").html('<center><h5 style="color:green"><i class="fa-solid fa-user-check"></i> Captcha Confirmado</h5></center>')
                            $("button[pagar]").attr("captcha",captcha);
                        }else{
                            $("#captcha").css("border-color","red");
                        }
                    }
                });
            }else{
                $("#captcha").css("border-color","");
            }
        });
        $(".atualizarCaptcha").click(function(){
            $(".imagemCaptcha").html('<img style="border-radius:5px;" src="src/produtos/captcha.php?l=150&a=45&tf=20&ql=5">');
        });

        $(".opcLoja").click(function(){
            $(".opcLoja").removeClass('list-group-item-info');
            obj = $(this);
            dados = obj.html();
            $(".loja").html(dados);
            obj.addClass('list-group-item-info');
            $("#collapseOne").removeClass('show');


            LjVl = obj.attr("valor");
            LjCd = obj.attr("opc");
            LjId = obj.attr("LjId");
            valor = $("div[dadosValores]").attr('valor');
            taxa = $("div[dadosValores]").attr('taxa');
            desconto = $("div[dadosValores]").attr('desconto');
            acrescimo = $("div[dadosValores]").attr('acrescimo');

            $.ajax({
                url:"src/produtos/pagar.php",
                type:"POST",
                dataType:"JSON",
                data:{
                    LjVl,
                    LjCd,
                    LjId,
                    valor,
                    taxa,
                    desconto,
                    acrescimo,
                    acao:'loja'
                },
                success:function(dados){
                    console.log(dados);
                    if(dados.status == false){
                        $("button[blq]").attr("blq",'s');
                        $.alert({
                            content:'<center><h1><i class="fa-solid fa-face-sad-tear" style="font-size:80px; color:#ccc;"></i></h1><p>Infelizmente não iremos poder te atender. Itens de sua cesta de pedidos está em falta.</p><center>',
                            title:false,
                            type:'red',
                            buttons:{
                                'ok':{
                                    text:'<i class="fa-regular fa-thumbs-up"></i> Entendi',
                                    btnClass:'btn btn-primary',
                                    action:function(){

                                    }
                                }
                            }
                        })
                    }else{
                        $("button[blq]").attr("blq",'n');
                    }
                }
            });

        });

        $("button[pagar]").click(function(){

            captcha = $("h5[robo]").attr("captcha");
            bloqueio = $(this).attr("blq");

            if(bloqueio == 's'){
                $.alert({
                    content:'<center><h1><i class="fa-solid fa-face-sad-tear" style="font-size:80px; color:#ccc;"></i></h1><p>Infelizmente não iremos poder te atender.<br><b>- Itens de sua cesta de pedidos está em falta.</b><br><b>- Ou não temos lojas disponíveis para fazer sua entrega.</b></p><center>',
                    title:false,
                    type:'red',
                    buttons:{
                        'ok':{
                            text:'<i class="fa-regular fa-thumbs-up"></i> Entendi',
                            btnClass:'btn btn-primary',
                            action:function(){

                            }
                        }
                    }
                })
                return false;
            }

            if(captcha == 'error') return false;

            opc = $(this).attr("opc");
            tentativas = $(this).attr("tentativas");
            captcha_valor = $(this).attr("captcha");

            if(opc == 'credito' && tentativas == 0){
                msg = '<div style="color:red"><center><h2><i class="fa-solid fa-ban"></i></h2>Você passou de três tentativas de pagamento com cartão de crédito. Favor selecionar outra forma de pagamento!</center></div>';
                $.alert(msg);
                return false;
            }

            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:'src/produtos/pagar_'+opc+'.php',
                    captcha:captcha_valor
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });


        $(".ConfirmaTelefone").click(function(){
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    // local:"src/cliente/confirmar_telefone.php",
                    local:"src/cliente/perfil.php",
                },
                success:function(dados){
                    $("body").attr("retorno","src/produtos/pagar.php");
                    $(".ms_corpo").append(dados);
                }
            });
        });

        $(".ConfirmaEndereco").click(function(){
            cod = $(this).attr('endereco');
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:"src/cliente/mapa_editar.php",
                    cod,
                },
                success:function(dados){
                    $("body").attr("retorno","src/produtos/pagar.php");
                    $(".ms_corpo").append(dados);
                }
            });
        });


        $(".alterar_endereco").click(function(){
            $.ajax({
                url:"componentes/ms_popup.php",
                type:"POST",
                data:{
                    local:"src/cliente/enderecos_trocar.php",
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

    })
</script>
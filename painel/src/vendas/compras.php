<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel','codVenda']);

    if($_POST['acao'] == 'excluir'){
        mysqli_query($con, "delete from vendas_produtos where codigo = '{$_POST['codigo']}'");
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }

    if($_POST['acao'] == 'comanda'){
        $q = "update vendas set comanda = '{$_POST['comanda']}' where codigo = '{$_SESSION['codVenda']}'";
        mysqli_query($con, $q);
    }

    if($_POST['acao'] == 'acrescimo'){
        $q = "update vendas set acrescimo = '{$_POST['acrescimo']}', tipo_acrescimo = '{$_POST['tipo_acrescimo']}' where codigo = '{$_SESSION['codVenda']}'";
        mysqli_query($con, $q);
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }

    if($_POST['acao'] == 'desconto'){
        $q = "update vendas set desconto = '{$_POST['desconto']}', tipo_desconto = '{$_POST['tipo_desconto']}' where codigo = '{$_SESSION['codVenda']}'";
        mysqli_query($con, $q);
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }

    if($_POST['local_entrega']){
        $q = "update vendas set retirada_estabelecimento = '0', local_entrega = '{$_POST['local_entrega']}', taxa_entrega = '{$_POST['valor_entrega']}' where codigo = '{$_SESSION['codVenda']}'";
        mysqli_query($con, $q);
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }


    if($_POST['acao'] == 'retirada_estabelecimento'){
        $q = "update vendas set retirada_estabelecimento = '{$_POST['retirada_estabelecimento']}', local_entrega = '0', taxa_entrega = '0' where codigo = '{$_SESSION['codVenda']}'";
        mysqli_query($con, $q);
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }


    function AtualizaComissao(){
        global $con;
        global $_POST;
        global $_SESSION;

        $q = "select a.*, b.valor as valor_venda, b.quantidade from colaboradores_produtos a left join vendas_produtos b on b.codigo = '{$_POST['codigo']}' where a.colaborador = '{$_POST['colaborador']}' and a.produto = '{$_POST['produto']}' and a.situacao = '1'";
        $com = mysqli_fetch_object(mysqli_query($con, $q));
        if($com->chave){
            $comissao_tipo = $com->tipo_comissao;
            $comissao_valor =  $com->valor;
            $comissao = (($com->tipo_comissao == 'p')?($com->valor_venda/100*$com->valor):($com->valor*$com->quantidade));
        }else{
            $comissao_tipo = 0;
            $comissao_valor =  0;
            $comissao = 0;
        }
        // echo "<br>";
        $query = "update vendas_produtos set
                                            colaborador = '{$_POST['colaborador']}',
                                            comissao_tipo = '{$comissao_tipo}',
                                            comissao_valor = '{$comissao_valor}',
                                            comissao = '{$comissao}'
                    where codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
    }

    if($_POST['acao'] == 'atualizar'){

        $query = "update vendas_produtos set quantidade = '{$_POST['quantidade']}', valor=(valor_unitario*".$_POST['quantidade'].") where codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);

        if($_POST['colaborador']){
            AtualizaComissao();
        }
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }


    if($_POST['acao'] == 'colaborador'){
        AtualizaComissao();
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");
    }

?>
<style>
    td, th{
        white-space: nowrap !important;
    }
</style>
<h5>Carrinho de compras</h5>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Descrição</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Valor Unitário</th>
                <th scope="col">Valor Total</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "select
                            a.*,
                            p.tipo,
                            p.codigo as cod_produto,
                            p.produto as produto_nome,
                            p.estoque,
                            d.nome as colaborador_nome,
                            if(p.tipo = 'p', 'Produto', 'Serviço') as tipo_nome,
                            c.categoria as categoria_nome
                        from vendas_produtos a
                            left join produtos p on a.produto = p.codigo
                            left join produtos_categorias c on p.categoria = c.codigo
                            left join colaboradores d on a.colaborador = d.codigo
                        where a.venda = '{$_SESSION['codVenda']}'";
            $result = mysqli_query($con, $query);
            $n = mysqli_num_rows($result);
            $valor = $comissao = 0;
            $tipo_produtos = false;
            if($n) $colaborador = true;
            while($d = mysqli_fetch_object($result)){

                if($d->tipo == 'p') $tipo_produtos = true;
                if(!$d->colaborador) $colaborador = false;
            ?>
            <tr <?=(($d->estoque < $d->quantidade and $d->categoria == '1')?"style='color:red'":false)?>>
                <td scope="row"><?=$d->cod_produto?></td>
                <td><b><?=$d->produto_nome?></b><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small></td>
                <td>
                    <button
                        menos="<?=$d->codigo?>"
                        produto="<?=$d->cod_produto?>"
                        colaborador="<?=$d->colaborador?>"
                        type="button"
                        class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-minus"></i></button>
                    <span qt="<?=$d->codigo?>" class="m-3"><?=$d->quantidade?></span>
                    <button
                        <?=(($d->estoque <= $d->quantidade)?'disabled':"mais=\"{$d->codigo}\"")?>
                        produto="<?=$d->cod_produto?>"
                        colaborador="<?=$d->colaborador?>"
                        type="button"
                        class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-plus"></i></button>
                </td>
                <td><?=$d->valor_unitario?></td>
                <td><?=$d->valor?></td>
                <td>
                    <!-- <button
                        type="button"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                        class="btn btn-sm btn-<?=(($d->colaborador)?'success':'secondary')?> colaborador"
                        codigo = "<?=$d->codigo?>"
                        produto = "<?=$d->cod_produto?>"
                    ><i class="fa-solid fa-clipboard-user"></i></button> -->


                    <div class="btn-group" role="group" aria-label="Basic example">
                    <div class="dropdown">
                    <button class="btn btn-<?=(($d->colaborador)?'success':'secondary')?>  btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-clipboard-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                    <?php

                        $query1 = "select * from colaboradores where situacao = '1' order by nome asc";
                        $result1 = mysqli_query($con, $query1);
                        while($c = mysqli_fetch_object($result1)){
                    ?>
                        <li><a
                                class="dropdown-item <?=(($d->colaborador == $c->codigo)?'active':false)?> ativar_colaborador"
                                href="#"
                                codigo = "<?=$d->codigo?>"
                                produto = "<?=$d->cod_produto?>"
                                colaborador = "<?=$c->codigo?>"
                            ><?=$c->nome?></a></li>
                    <?php
                        }
                    ?>
                    </ul>
                    </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger excluir" codigo="<?=$d->codigo?>" produto="<?=$d->produto_nome?>"><i class="fa-regular fa-trash-can"></i></button>
                </td>
            </tr>
            <?php
                // Dados para calculo das somas totais e das comissões
                $valor = $valor + $d->valor;
                $comissao = $comissao + $d->comissao;
            }

            $q = "update vendas set
                                                valor = '{$valor}',
                                                comissao = '{$comissao}',
                                                ".((!$tipo_produtos)?"taxa_entrega = '0', local_entrega = '0', ":false)."
                                                total = ({$valor}".(($tipo_produtos)?" + taxa_entrega":false)." + taxa - if(tipo_desconto = 'p', ({$valor}/100*desconto), desconto) + if(tipo_acrescimo = 'p', ({$valor}/100*acrescimo), acrescimo)/* - {$comissao}*/)
                        where codigo = '{$_SESSION['codVenda']}'";
            mysqli_query($con, $q);

            ?>
        </tbody>
    </table>
</div>

<?php
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
    $d = mysqli_fetch_object($result);

    if(mysqli_num_rows($result)) $entrega = true;

?>
<div class="row">

    <div class="col-md-2">
        <label for="desconto" class="form-label">Comanda</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
            <input type="text" id="comanda" class="form-control" value="<?=$d->comanda?>" />
            <button class="btn btn-outline-secondary" type="button" id="button-comanda"><i class="fa-regular fa-floppy-disk"></i></button>
        </div>
    </div>

    <div class="col-md-2">
        <label for="valor" class="form-label">Valor</label>
        <div class="input-group mb-3">
            <span class="input-group-text">R$</span>
            <div type="number" class="form-control"><?=$d->valor?></div>
        </div>
    </div>


    <?php
    if($tipo_produtos){

        if(!$d->local_entrega and $d->retirada_estabelecimento == '0') $entrega = false;

    ?>
    <div class="col-md-2">
        <label for="entrega" class="form-label">Entrega</label>
        <div class="input-group mb-3">
            <span class="input-group-text">R$</span>
            <div class="form-control"><?=$d->taxa_entrega?></div>
            <button
                    type="button"
                    id="button-addon1"
                    class="btn btn-outline-<?=(($d->local_entrega > 0 || $d->retirada_estabelecimento == '1')?'success':'secondary')?> taxa_entrega"
                    type="button"
                    id="button-acrescimo"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasDireita"
                    retirada_estabelecimento = "<?=$d->retirada_estabelecimento?>"
                    local_entrega = "<?=$d->local_entrega?>"
            ><i class="fa-solid fa-location-dot"></i></button>
        </div>
    </div>
    <?php
    }
    ?>

    <div class="col-md-2">
        <label for="tipo_acrescimo" class="form-label">Acrescimo</label>
        <div class="input-group mb-3">
            <!-- <span class="input-group-text">R$</span> -->
            <select tipo_acrescimo class="form-control" >
                <option value="v" <?=(($d->tipo_acrescimo == 'v')?'selected':false)?>>R$</option>
                <option value="p" <?=(($d->tipo_acrescimo == 'p')?'selected':false)?>>%</option>
            </select>
            <input type="text" data-thousands="" data-decimal="." id="tipo_acrescimo" class="form-control" value="<?=$d->acrescimo?>" />
            <button class="btn btn-outline-secondary" type="button" id="button-tipo_acrescimo"><i class="fa-regular fa-floppy-disk"></i></button>
        </div>

    </div>
    <div class="col-md-2">
        <label for="tipo_desconto" class="form-label">Desconto</label>
        <div class="input-group mb-3">
            <!-- <span class="input-group-text">R$</span> -->
            <select tipo_desconto class="form-control" >
                <option value="v" <?=(($d->tipo_desconto == 'v')?'selected':false)?>>R$</option>
                <option value="p" <?=(($d->tipo_desconto == 'p')?'selected':false)?>>%</option>
            </select>
            <input type="text" data-thousands="" data-decimal="." id="tipo_desconto" class="form-control" value="<?=$d->desconto?>" />
            <button class="btn btn-outline-secondary" type="button" id="button-tipo_desconto"><i class="fa-regular fa-floppy-disk"></i></button>
        </div>
    </div>

    <div class="col-md-2">
        <label for="total" class="form-label">Total</label>
        <div class="input-group mb-3">
            <span class="input-group-text">R$</span>
            <div type="number" class="form-control"><?=(
                                                            $d->valor +
                                                            $d->taxa_entrega +
                                                            (($d->tipo_acrescimo == 'p')?($d->valor/100*$d->acrescimo):$d->acrescimo) -
                                                            (($d->tipo_desconto == 'p')?($d->valor/100*$d->desconto):$d->desconto)
                                                        )
                                                    ?></div>
            <button
                data-bs-toggle="offcanvas"
                href="#offcanvasDireita"
                role="button"
                aria-controls="offcanvasDireita"
                class="btn btn-outline-secondary"
                type="button"
                id="button-pagar"
            ><i class="fa-solid fa-cash-register"></i></button>
        </div>
    </div>

    <p style="text-align:center; font-size:12px; color:#a1a1a1;">Atendimento / Pedido para: <b><?=$_SESSION['ClienteAtivoNome']?></b> <?=(($d->local_entrega)?"({$d->endereco})":(($d->retirada_estabelecimento)?' (Retirada no estabelecimento)':false))?></p>
</div>


<script>
    $(function(){

        Carregando('none')

        $('#tipo_desconto').maskMoney();
        $('#tipo_acrescimo').maskMoney();


        $('.CarrinhoQt').html(<?=$n?>);
        function UpdateQuantidade(codigo, quantidade, produto, colaborador){

            $.ajax({
                url:"src/vendas/compras.php",
                type:"POST",
                data:{
                    codigo,
                    quantidade,
                    produto,
                    colaborador,
                    acao:'atualizar'
                },
                success:function(dados){
                    // console.log('success');
                    $(".produtos_lista").html(dados);
                },
                error:function(){
                    console.log('Error');
                }
            });

        }


        $("button[menos]").click(function(){
            codigo = $(this).attr("menos");
            produto = $(this).attr("produto");
            colaborador = $(this).attr("colaborador");
            quantidade = $(`span[qt="${codigo}"]`).text();
            if(quantidade <= 1){
                quantidade = 1;
            }else{
                quantidade--;
            }
            $(`span[qt="${codigo}"]`).text(quantidade);
            UpdateQuantidade(codigo, quantidade, produto, colaborador)
            // console.log(codigo)
        });
        // Teste

        $("button[mais]").click(function(){
            codigo = $(this).attr("mais");
            produto = $(this).attr("produto");
            colaborador = $(this).attr("colaborador");
            quantidade = $(`span[qt="${codigo}"]`).text();
            quantidade++;
            $(`span[qt="${codigo}"]`).text(quantidade);
            // console.log(codigo)
            UpdateQuantidade(codigo, quantidade, produto, colaborador)
        });



        $(".colaborador").click(function(){
            codigo = $(this).attr("codigo");
            produto = $(this).attr("produto");
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    codigo,
                    produto,
                },
                url:"src/vendas/lista_profissionais.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })


        $("#button-comanda").click(function(){
            comanda = $("#comanda").val();
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    comanda,
                    acao:'comanda'
                },
                url:"src/vendas/compras.php",
                success:function(dados){
                    $(".produtos_lista").html(dados);
                }
            });
        });

        $("#button-tipo_acrescimo").click(function(){
            acrescimo = $("#tipo_acrescimo").val();
            tipo_acrescimo = $("select[tipo_acrescimo]").val();
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    acrescimo,
                    tipo_acrescimo,
                    acao:'acrescimo'
                },
                url:"src/vendas/compras.php",
                success:function(dados){
                    $(".produtos_lista").html(dados);
                }
            });
        });

        $("#button-tipo_desconto").click(function(){
            desconto = $("#tipo_desconto").val();
            tipo_desconto = $("select[tipo_desconto]").val();
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    desconto,
                    tipo_desconto,
                    acao:'desconto'
                },
                url:"src/vendas/compras.php",
                success:function(dados){
                    $(".produtos_lista").html(dados);
                }
            });
        });


        $("button.taxa_entrega").click(function(){
            Carregando();
            retirada_estabelecimento = $(this).attr("retirada_estabelecimento");
            local_entrega = $(this).attr("local_entrega");
            $.ajax({
                url:"src/vendas/enderecos_entrega.php",
                type:"POST",
                data:{
                    retirada_estabelecimento,
                    local_entrega
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });

        $("#button-pagar").click(function(){


            <?=(($entrega)?'msgE = ``;':'msgE = `<div class="row" style="padding:0; margin:0;"><div class="col-1"><i class="fa-solid fa-location-dot"></i></div><div class="col-11">Você ainda não definiu o local de entrega.</div></div>`;')?>
            <?=(($colaborador)?'msgC = ``;':'msgC = `<div class="row" style="padding:0; margin:0;"><div class="col-1"><i class="fa-solid fa-clipboard-user"></i></div><div class="col-11">Você ainda não definiu atendente/colaborador em um ou mais serviços/produtos.</div></div>`;')?>

            if(msgC || msgE){
                $.alert({
                    content:`${msgE} ${msgC}`,
                    title:"Pendências",
                    type:'red'
                });

                let myOffCanvas = document.getElementById('offcanvasDireita');
                let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                openedCanvas.hide();

                return false;
            }

            Carregando();

            $.ajax({
                url:"src/vendas/comanda.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });

        $(".excluir").click(function(){
            codigo = $(this).attr("codigo");
            produto = $(this).attr("produto");
            $.confirm({
                content:`Deseja realmente excluir o produto ${produto}?`,
                title:"Excluir produto da lista",
                type:"red",
                buttons:{
                    'Sim':{
                        text:'Sim',
                        btnClass:'btn btn-danger btn-sm',
                        action:function(){
                            Carregando();
                            $.ajax({
                                type:"POST",
                                data:{
                                    codigo,
                                    produto,
                                    acao:'excluir'
                                },
                                url:"src/vendas/compras.php",
                                success:function(dados){
                                    $(".produtos_lista").html(dados);
                                }
                            });
                        },
                    },
                    'Não':{
                        text:'Não',
                        btnClass:'btn btn-success btn-sm',
                        action:function(){

                        }
                    }
                }
            });

        })


        $(".ativar_colaborador").click(function(){
            codigo = $(this).attr("codigo");
            produto = $(this).attr("produto");
            colaborador = $(this).attr("colaborador");
            // nome = $(this).html();
            Carregando();
            $.ajax({
                type:"POST",
                data:{
                    codigo,
                    produto,
                    colaborador,
                    acao:'colaborador'
                },
                url:"src/vendas/compras.php",
                success:function(dados){
                    // Carregando('none');
                    $(".produtos_lista").html(dados);
                }
            });

            // $(".dados_profissionais").attr("codigo", codigo);
            // $(".dados_profissionais").html(nome);

            // let myOffCanvas = document.getElementById('offcanvasDireita');
            // let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            // openedCanvas.hide();

        });


    })
</script>
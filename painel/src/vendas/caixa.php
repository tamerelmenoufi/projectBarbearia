<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    if($_POST['acao'] == 'fechar_pedido'){
        // echo "FECHAR O PEDIDO";
        list($agenda) = mysqli_fetch_row(mysqli_query($con, "select agenda from vendas where codigo = '{$_SESSION['codVenda']}'"));
        $query = "update vendas set situacao = 'p', data_pedido = NOW() where codigo = '{$_SESSION['codVenda']}'";
        $result = mysqli_query($con, $query);
        if ($result and $agenda){
            echo $q = "update vendas_produtos set situacao = 'c' where codigo in ($agenda)";
            mysqli_query($con, $q);
        }
    }


    if($_POST['codCliente']){
        $_SESSION['ClienteAtivo'] = $_POST['codCliente'];
        $_SESSION['ClienteAtivoNome'] = $_POST['nomeCliente'];
    }

    if($_SESSION['ClienteAtivo']){


        function AtualizaComissao($cod_venda_produto, $cod_produto, $cod_colaborador){
            global $con;

            $q = "select a.*, b.valor as valor_venda, b.quantidade from colaboradores_produtos a left join vendas_produtos b on b.codigo = '{$cod_venda_produto}' where a.colaborador = '{$cod_colaborador}' and a.produto = '{$cod_produto}'/* and a.situacao = '1'*/";
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
                                                colaborador = '{$cod_colaborador}',
                                                comissao_tipo = '{$comissao_tipo}',
                                                comissao_valor = '{$comissao_valor}',
                                                comissao = '{$comissao}'
                        where codigo = '{$cod_venda_produto}'";
            mysqli_query($con, $query);
        }


        function IncluirServicos($agenda){
            global $con;
            global $_SESSION;
            list($servicos, $colaborador) = mysqli_fetch_row(mysqli_query($con, "select servico, colaborador from agenda where codigo = '{$agenda}'"));
            if($servicos){
                $servicos = json_decode($servicos);
                foreach($servicos as $ind => $cod){
                    $p = mysqli_fetch_object(mysqli_query($con, "select * from produtos where codigo = '{$cod}'"));
                    $qt = 1;
                    $query = "insert into vendas_produtos set
                                    agenda = '{$agenda}',
                                    venda = '{$_SESSION['codVenda']}',
                                    cliente = '{$_SESSION['ClienteAtivo']}',
                                    colaborador = '{$colaborador}',

                                    produto_tipo = '{$p->tipo}',
                                    categoria = '{$p->categoria}',
                                    produto = '{$p->codigo}',
                                    valor_unitario = '{$p->valor}',
                                    quantidade = '{$qt}',
                                    valor = '".($qt*$p->valor)."',

                                    comissao_tipo = '',
                                    comissao_valor = '',
                                    comissao = '',

                                    total = '".($qt*$p->valor)."',
                                    situacao = 'n',
                                    data_pedido = ''
                    ";
                    $result = mysqli_query($con,$query);
                    $cod_venda_produto = mysqli_insert_id($con);
                    AtualizaComissao($cod_venda_produto, $p->codigo, $colaborador);
                }
            }
        }




        $query = "select a.*,
                        (select codigo from vendas where cliente = a.codigo and situacao = 'n' and deletado != '1') as venda,
                        (select agenda from vendas where cliente = a.codigo and situacao = 'n' and deletado != '1') as agenda
                    from clientes a where a.codigo = '{$_SESSION['ClienteAtivo']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        if(!$d->venda){
            mysqli_query($con, "insert into vendas set cliente = '{$d->codigo}', colaborador = '{$_SESSION['ProjectPainel']->codigo}', situacao = 'n'".(($_POST['agenda'])?", agenda = '".(($d->agenda)?$d->agenda.','.$_POST['agenda']:$_POST['agenda'])."'":false));
            $_SESSION['codVenda'] = mysqli_insert_id($con);
            $vagenda = explode(",",$d->agenda);
            if(!in_array($_POST['agenda'],$vagenda)){
                IncluirServicos($_POST['agenda']);
            }

        }else{
            $_SESSION['codVenda'] = $d->venda;
            if($_POST['agenda']){
                mysqli_query($con, "update vendas set agenda = '".(($d->agenda)?$d->agenda.','.$_POST['agenda']:$_POST['agenda'])."' where codigo = '{$d->venda}'");
            }
            $vagenda = explode(",",$d->agenda);
            if(!in_array($_POST['agenda'],$vagenda)){
                IncluirServicos($_POST['agenda']);
            }
        }

        list($qtr) = mysqli_fetch_row(mysqli_query($con, "select count(*) from vendas_produtos where venda = '{$_SESSION['codVenda']}' "));
    }


?>
<style>
    .produtos_lista{
        border-left:#dee2e6 solid 1px;
        border-right:#dee2e6 solid 1px;
        border-bottom:#dee2e6 solid 1px;
    }
    .remove{
        display:<?=(($_SESSION['ClienteAtivo'])?'block':'none')?>;
    }
</style>
<div class="p-3" style="position:fixed; left:0px; top:65px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <?php
        /*
        ?>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-clock" style="margin-right:10px;"></i>Profissional</span>
                <div class="form-control dados_profissionais" codigo="" ></div>
                <button
                        class="btn btn-outline-secondary listar_profissionais"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                        type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
        <?php
        //*/
        ?>
        <div class="col-md-12">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-check" style="margin-right:10px;"></i>Cliente</span>
                <div class="form-control dados_clientes" codigo="<?=$d->codigo?>"><?=$d->nome?></div>
                <button
                        class="btn btn-outline-secondary listar_clientes"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                        type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    </div>
    <div class="row categorias_list remove"></div>
</div>

<div class="p-3 remove" style="position:fixed; left:0px; top:200px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-produtos" data-bs-toggle="tab" data-bs-target="#painel-vendas" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Produtos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="home-compras" data-bs-toggle="tab" data-bs-target="#painel-vendas" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        Carrinho de Compras
                        <span class="CarrinhoQt"><?=$qtr?></span>
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active produtos_lista p-3" id="painel-vendas" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');
        <?php
        //Verifica se tem cliente ativo para iniciar uma venda
        if($_SESSION['ClienteAtivo']){
        ?>
        $.ajax({
            url:"src/vendas/categorias.php",
            success:function(dados){
                $(".categorias_list").html(dados);
            }
        });

        $.ajax({
            url:"src/vendas/produtos.php",
            success:function(dados){
                $(".produtos_lista").html(dados);
            }
        });
        <?php
        }//Verifica se tem cliente ativo para iniciar uma venda
        ?>

        $(".listar_profissionais").click(function(){
            Carregando();
            $.ajax({
                url:"src/vendas/lista_profissionais.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })

        $(".listar_clientes").click(function(){
            Carregando();
            $.ajax({
                url:"src/vendas/lista_clientes.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })

        $("#home-produtos").click(function(){
            Carregando();
            $.ajax({
                url:"src/vendas/produtos.php",
                success:function(dados){
                    $(".produtos_lista").html(dados);
                }
            });
        })

        $("#home-compras").click(function(){
            Carregando();
            $.ajax({
                url:"src/vendas/compras.php",
                success:function(dados){
                    $(".produtos_lista").html(dados);
                }
            });
        })

    })
</script>
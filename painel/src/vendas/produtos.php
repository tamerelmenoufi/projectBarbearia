<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    if($_POST['codProduto']){

        vl(['ProjectPainel','ClienteAtivo','codVenda']);

        $p = mysqli_fetch_object(mysqli_query($con, "select * from produtos where codigo = '{$_POST['codProduto']}'"));
        $qt = (($_POST['quantidade']?:1));
        $query = "insert into vendas_produtos set
                        venda = '{$_SESSION['codVenda']}',
                        cliente = '{$_SESSION['ClienteAtivo']}',
                        colaborador = '',

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

        list($qtr) = mysqli_fetch_row(mysqli_query($con, "select count(*) from vendas_produtos where venda = '{$_SESSION['codVenda']}' "));
        mysqli_query($con, "delete from vendas_pagamentos where venda = '{$_SESSION['codVenda']}'");

        echo json_encode([
            'status' => true,
            'qt' => $qtr
        ]);

        exit();


    }

    if($_POST['codCategoria']){
        $_SESSION['codCategoria'] = $_POST['codCategoria'];
        $_SESSION['nomeCategoria'] = $_POST['nomeCategoria'];
    }
    if($_POST['codCategoria'] == 'tudo'){
        $_SESSION['codCategoria'] = false;
        $_SESSION['nomeCategoria'] = false;
    }

    if($_SESSION['codCategoria']){ $categoria = "and categoria = '{$_SESSION['codCategoria']}'"; }



?>
<style>

</style>
<div class="row">
    <h5><?=(($_SESSION['nomeCategoria'])?:'Todos os Produtos')?></h5>
<?php

    $query = "select * from produtos where situacao = '1' and valor > 0 and estoque > 0 {$categoria} order by vendas desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

?>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?=$d->produto?></h5>
                    <!-- <p class="card-text"><?=$d->descricao?></p> -->
                    <p class="card-text">R$ <?=number_format($d->valor, 2, ',','.')?></p>
                    <p class="card-text" style="text-align:right">
                        <button class="btn btn-success btn-sm" addProduto="<?=$d->codigo?>"><i class="fa-solid fa-cart-plus"></i> Incluir</button>
                    </p>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>
</div>
<script>
    $(function(){
        Carregando('none');

        $("button[addProduto]").click(function(){
            codProduto = $(this).attr("addProduto");
            console.log(codProduto)
            Carregando();
            $.ajax({
                url:"src/vendas/produtos.php",
                type:"POST",
                dataType:'json',
                data:{
                    codProduto
                },
                success:function(dados){
                    console.log(dados.qt)
                    $('.CarrinhoQt').html(dados.qt)
                    Carregando('none');
                },
                error:function(){
                    console.log('Erro ocorrido')
                    Carregando('none');
                }
            });
        })

    })
</script>
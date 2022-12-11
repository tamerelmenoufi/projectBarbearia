<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel','codVenda']);

    function AtualizaComissao(){
        global $con;
        global $_POST;
        global $_SESSION;

        echo $q = "select *, (select valor from vendas_produtos where codigo = '{$_POST['codigo']}') as valor_venda from colaboradores_produtos where colaborador = '{$_POST['profissional']}' and produto = '{$_POST['produto']}' and situacao = '1'";
        $com = mysqli_fetch_object(mysqli_query($con, $q));
        if($com->chave){
            $comissao_tipo = $com->tipo_comissao;
            $comissao_valor =  $com->valor;
            $comissao = (($com->tipo_comissao == 'p')?($com->valor_venda/100*$com->valor):$com->valor*$com->quantidade);
        }else{
            $comissao_tipo = 0;
            $comissao_valor =  0;
            $comissao = 0;
        }
        echo "<br>";
        echo $query = "update vendas_produtos set
                                            colaborador = '{$_POST['profissional']}',
                                            comissao_tipo = '{$comissao_tipo}',
                                            comissao_valor = '{$comissao_valor}',
                                            comissao = '{$comissao}'
                    where codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
    }

    if($_POST['acao'] == 'atualizar'){

        $query = "update vendas_produtos set quantidade = '{$_POST['quantidade']}', valor=(valor_unitario*".$_POST['quantidade'].") where codigo = '{$_POST['produto']}'";
        mysqli_query($con, $query);

        if($_POST['colaborador']){
            AtualizaComissao();
        }

    }


    if($_POST['acao'] == 'profissional'){
        AtualizaComissao();
    }




?>
<style>
    td{
        white-space: nowrap;
    }
</style>
<h5>Carrinho de compras</h5>

Meu código de Compra é <?=$_SESSION['codVenda']?>

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
                            p.codigo as cod_produto,
                            p.produto as produto_nome,
                            if(p.tipo = 'p', 'Produto', 'Serviço') as tipo_nome,
                            c.categoria as categoria_nome
                        from vendas_produtos a
                            left join produtos p on a.produto = p.codigo
                            left join produtos_categorias c on p.categoria = c.codigo
                        where a.venda = '{$_SESSION['codVenda']}'";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <tr>
                <th scope="row"><?=$d->cod_produto?></th>
                <td><b><?=$d->produto_nome?></b><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small></td>
                <td>
                    <button menos="<?=$d->codigo?>" produto="<?=$d->cod_produto?>" colaborador="<?=$d->colaborador?>" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-minus"></i></button>
                    <span qt="<?=$d->codigo?>" class="m-3"><?=$d->quantidade?></span>
                    <button mais="<?=$d->codigo?>" produto="<?=$d->cod_produto?>" colaborador="<?=$d->colaborador?>" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-plus"></i></button>
                </td>
                <td><?=$d->valor_unitario?></td>
                <td><?=$d->valor?></td>
                <td>
                    <button
                            type="button"
                            data-bs-toggle="offcanvas"
                            href="#offcanvasDireita"
                            role="button"
                            aria-controls="offcanvasDireita"
                            class="btn btn-sm btn-<?=(($d->colaborador)?'success':'secondary')?> profissional"
                            codigo = "<?=$d->codigo?>"
                            produto = "<?=$d->cod_produto?>"
                    ><i class="fa-solid fa-clipboard-user"></i></button>
                    <button type="button" class="btn btn-sm btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(function(){
        Carregando('none')

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
            $(`span[qt="${pd}"]`).text(quantidade);
            UpdateQuantidade(codigo, quantidade, produto, colaborador)
            // console.log(pd)
        });
        // Teste

        $("button[mais]").click(function(){
            codigo = $(this).attr("mais");
            produto = $(this).attr("produto");
            colaborador = $(this).attr("colaborador");
            quantidade = $(`span[qt="${pd}"]`).text();
            quantidade++;
            $(`span[qt="${codigo}"]`).text(quantidade);
            // console.log(pd)
            UpdateQuantidade(codigo, quantidade, produto, colaborador)
        });



        $(".profissional").click(function(){
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

    })
</script>
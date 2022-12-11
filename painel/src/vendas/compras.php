<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel','codVenda']);

    if($_POST['acao'] == 'atualizar'){

        $query = "update vendas_produtos set quantidade = '{$_POST['quantidade']}', valor=(valor_unitario*".$_POST['quantidade'].") where codigo = '{$_POST['produto']}'";
        mysqli_query($con, $query);

    }



?>
<style>
    td{
        weight-space: nowrap;
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
                    <button menos="<?=$d->codigo?>" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-minus"></i></button>
                    <span qt="<?=$d->codigo?>" class="m-3"><?=$d->quantidade?></span>
                    <button mais="<?=$d->codigo?>" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-plus"></i></button>
                </td>
                <td><?=$d->valor_unitario?></td>
                <td><?=$d->valor?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-secondary"><i class="fa-solid fa-clipboard-user"></i></button>
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

        function UpdateQuantidade(produto, quantidade){

            $.ajax({
                url:"src/vendas/compras.php",
                type:"POST",
                data:{
                    produto,
                    quantidade,
                    acao:'atualizar'
                },
                success:function(dados){
                    console.log('success');
                    $(".produtos_lista").html(dados);
                },
                error:function(){
                    console.log('Error');
                }
            });

        }


        $("button[menos]").click(function(){
            pd = $(this).attr("menos");
            qt = $(`span[qt="${pd}"]`).text();
            if(qt <= 1){
                qt = 1;
            }else{
                qt--;
            }
            $(`span[qt="${pd}"]`).text(qt);
            UpdateQuantidade(pd, qt)
            // console.log(pd)
        });
        // Teste

        $("button[mais]").click(function(){
            pd = $(this).attr("mais");
            qt = $(`span[qt="${pd}"]`).text();
            qt++;
            $(`span[qt="${pd}"]`).text(qt);
            // console.log(pd)
            UpdateQuantidade(pd, qt)
        });


    })
</script>
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel','codVenda']);




?>

<h5>Carrinho de compras</h5>

Meu código de Compra é <?=$_SESSION['codVenda']?>


<table class="table table-hover">

    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Valor Unitário</th>
            <th scope="col">Valor Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        echo $query = "select
                        a.*,
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
            <th scope="row"><?=$d->codigo?></th>
            <td><b><?=$d->produto_nome?></b><br><small><?=$d->categoria_nome?> (<?=$d->tipo_nome?>)</small></td>
            <td><?=$d->quantidade?></td>
            <td><?=$d->valor_unitario?></td>
            <td><?=$d->valor?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>

</table>


<script>
    $(function(){
        Carregando('none')
    })
</script>
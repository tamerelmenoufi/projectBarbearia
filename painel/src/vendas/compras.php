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
            <th scope="col">tipo</th>
            <th scope="col">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "select * from vendas_produtos where venda = '{$_SESSION['codVenda']}'";
        $result = mysqli_query($con, $query);
        while($d = mysqli_fetch_object($result)){
        ?>
        <tr>
            <th scope="row"><?=$d->codigo?></th>
            <td><?=$d->produto?></td>
            <td><?=$d->produto_tipo?></td>
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
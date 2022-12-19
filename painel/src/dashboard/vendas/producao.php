<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<h5>Pedidos em Produção</h5>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cliente</th>
                <th scope="col">Data</th>
                <th scope="col">Valor</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "select
                            a.*,
                            b.nome as cliente_nome
                        from vendas a
                        left join clientes b on a.cliente = b.codigo
                        where a.situacao = 'p'";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <tr>
                <td scope="row"><?=$d->codigo?></td>
                <td><?=$d->cliente_nome?></td>
                <td><?=$d->data_pedido?></td>
                <td><?=$d->valor?></td>
                <td>
                    <button
                        type="button"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                        class="btn btn-sm btn-<?=(($d->colaborador)?'success':'secondary')?> colaborador"
                        codigo = "<?=$d->codigo?>"
                        produto = "<?=$d->cod_produto?>"
                    ><i class="fa-solid fa-clipboard-user"></i></button>
                    <button type="button" class="btn btn-sm btn-danger excluir" codigo="<?=$d->codigo?>" produto="<?=$d->produto_nome?>"><i class="fa-regular fa-trash-can"></i></button>
                </td>
            </tr>
            <?php
                // Dados para calculo das somas totais e das comissões
                $valor = $valor + $d->valor;
                $comissao = $comissao + $d->comissao;
            }

            ?>
        </tbody>
    </table>
</div>
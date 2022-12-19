<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<h5>Pedidos em Produção</h5>
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
                            *
                        from vendas
                        where situacao = 'p'";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <tr>
                <th scope="row"><?=$d->codigo?></th>
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
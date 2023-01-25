<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .solicitar_entrega{
        cursor:pointer;
        color:green;
    }
    .cancelar_pedido{
        cursor:pointer;
        color:red;
    }
    td{
        white-space: nowrap;
    }
</style>
<h6>Pedidos em Produção</h6>
<div class="table-responsive" style="font-size:12px;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cliente</th>
                <th scope="col">Data</th>
                <th scope="col">Valor</th>
                <!-- <th scope="col">Ações</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "select
                            a.*,
                            b.nome as cliente_nome
                        from vendas a
                        left join clientes b on a.cliente = b.codigo
                        where a.situacao = 'p' order by data_pedido desc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <tr>
                <td scope="row"><?=$d->codigo?></td>
                <td><?=$d->cliente_nome?></td>
                <td><?=$d->data_pedido?></td>
                <td>R$ <?=number_format($d->valor, 2, ",",".")?></td>
                <!-- <td>
                    <i class="fa-solid fa-motorcycle solicitar_entrega"></i>
                    <i class="fa-solid fa-ban ms-3 cancelar_pedido"></i>
                </td> -->
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
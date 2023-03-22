<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .relatorio{
        cursor: pointer;
    }
</style>
<h6>Relatórios Gerais</h6>
<!-- <ul class="list-group">
    <li class="list-group-item relatorio p-3">Total de agendas</li>
    <li class="list-group-item relatorio p-3">Agendas atendidas</li>
    <li class="list-group-item relatorio p-3">Agendas não atendidas</li>
    <li class="list-group-item relatorio p-3">Total de vendas</li>
    <li class="list-group-item relatorio p-3">Vendas por serviços</li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3"></li>
    <li class="list-group-item relatorio p-3">Estatísticas dos produtos</li>
</ul> -->

<div class="accordion accordion-flush" id="relatoriosEstatisticas">

    <?php
    /////////////////////////////////////////////////////////////////
    $query = "select count(*) as qt from agenda where data_agenda >= NOW()";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    ?>

    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Total de Agendas</div>
            <div class="col text-end"><?=$d->qt.(($d->qt>1)?' Itens':' Item')?></div>
        </div>
    </div>


    <?php
    /////////////////////////////////////////////////////////////////
    $query = "select count(*) as qt from agenda where situacao = 'c'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    ?>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Agendas Atendidas</div>
            <div class="col text-end"><?=$d->qt.(($d->qt>1)?' Itens':' Item')?></div>
        </div>
    </div>


    <?php
    /////////////////////////////////////////////////////////////////
    $query = "select count(*) as qt from agenda where situacao = 'n' and data_agenda < NOW()";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    ?>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Agendas não Atendidas</div>
            <div class="col text-end"><?=$d->qt.(($d->qt>1)?' Itens':' Item')?></div>
        </div>
    </div>


    <?php
    /////////////////////////////////////////////////////////////////
    $query = "select count(*) as qt, sum(valor) as valor from vendas where situacao = 'p'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    ?>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Total de vendas</div>
            <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
            <div class="col text-end">R$ <?=number_format($d->valor,2,',','.')?></div>
        </div>
    </div>



    <div class="accordion-item">
        <h2 class="accordion-header" id="open_venda_servico">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#close_venda_servico" aria-expanded="false" aria-controls="close_venda_servico">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Vendas por serviços</div>
                <!-- <div class="col text-end">232</div> -->
            </div>

        </button>
        </h2>
        <div id="close_venda_servico" class="accordion-collapse collapse" aria-labelledby="open_venda_servico" data-bs-parent="#relatoriosEstatisticas">
        <div class="accordion-body">

        <ul class="list-group">
        <?php
        /////////////////////////////////////////////////////////////////
        $query = "select
                        a.*,
                        sum(a.valor) as valor_total,
                        b.produto as nome_produto,
                        count(*) as qt
                    from vendas_produtos a
                        left join produtos b on a.produto = b.codigo
                        left join vendas c on a.venda = c.codigo
                    where c.situacao = 'p' and a.produto_tipo = 's' group by a.produto order by a.codigo desc";
        $result = mysqli_query($con, $query);
        $n = mysqli_num_rows($result);
        while($d = mysqli_fetch_object($result)){
        ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?=$d->nome_produto?>
                <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
                <span class="badge bg-primary rounded-pill">R$ <?=number_format($d->valor_total,2,',','.')?></span>
            </li>
        <?php
        }
        if(!$n){
        ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h4 class="w-100 text-center" style="color:#a1a1a1;">CATEGORIA SEM REGISTROS</h4>
            </li>
        <?php
        }
        ?>
        </ul>
        </div>
        </div>
    </div>


    <div class="accordion-item">
        <h2 class="accordion-header" id="open_vendas_produtos">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#close_vendas_produtos" aria-expanded="false" aria-controls="close_vendas_produtos">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Vendas por produtos</div>
                <!-- <div class="col text-end">232</div> -->
            </div>

        </button>
        </h2>
        <div id="close_vendas_produtos" class="accordion-collapse collapse" aria-labelledby="open_vendas_produtos" data-bs-parent="#relatoriosEstatisticas">
        <div class="accordion-body">
            <ul class="list-group">
            <?php
            /////////////////////////////////////////////////////////////////
            $query = "select
                            a.*,
                            sum(a.valor) as valor_total,
                            b.produto as nome_produto,
                            count(*) as qt
                        from vendas_produtos a
                            left join produtos b on a.produto = b.codigo
                            left join vendas c on a.venda = c.codigo
                        where c.situacao = 'p' and a.produto_tipo = 'p' group by a.produto order by a.codigo desc";
            $result = mysqli_query($con, $query);
            $n = mysqli_num_rows($result);
            while($d = mysqli_fetch_object($result)){
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?=$d->nome_produto?>
                    <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
                    <span class="badge bg-primary rounded-pill">R$ <?=number_format($d->valor_total,2,',','.')?></span>
                </li>
            <?php
            }
            if(!$n){
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h4 class="w-100 text-center" style="color:#a1a1a1;">CATEGORIA SEM REGISTROS</h4>
                </li>
            <?php
            }
            ?>
            </ul>
        </div>
        </div>
    </div>



    <div class="accordion-item">
        <h2 class="accordion-header" id="open_vendas_colaborador">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#close_vendas_colaborador" aria-expanded="false" aria-controls="close_vendas_colaborador">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Vendas por colaborador</div>
                <!-- <div class="col text-end">232</div> -->
            </div>

        </button>
        </h2>
        <div id="close_vendas_colaborador" class="accordion-collapse collapse" aria-labelledby="open_vendas_colaborador" data-bs-parent="#relatoriosEstatisticas">
        <div class="accordion-body">
            <ul class="list-group">
            <?php
            /////////////////////////////////////////////////////////////////
            $query = "select
                            a.*,
                            sum(a.valor) as valor_total,
                            b.nome as nome_colaborador,
                            count(*) as qt
                        from vendas_produtos a
                            left join colaboradores b on a.colaborador = b.codigo
                            left join vendas c on a.venda = c.codigo
                        where c.situacao = 'p' group by a.colaborador order by a.codigo desc";
            $result = mysqli_query($con, $query);
            $n = mysqli_num_rows($result);
            while($d = mysqli_fetch_object($result)){
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?=$d->nome_colaborador?>
                    <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
                    <span class="badge bg-primary rounded-pill">R$ <?=number_format($d->valor_total,2,',','.')?></span>
                </li>
            <?php
            }
            if(!$n){
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h4 class="w-100 text-center" style="color:#a1a1a1;">CATEGORIA SEM REGISTROS</h4>
                </li>
            <?php
            }
            ?>
            </ul>
        </div>
        </div>
    </div>



    <?php
    /////////////////////////////////////////////////////////////////
    $query = "select count(*) as qt, sum(total) as valor from vendas where situacao = 'p'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    ?>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Financeiro Líquido</div>
            <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
            <div class="col text-end">R$ <?=number_format($d->valor,2,',','.')?></div>
        </div>
    </div>


    <?php
    /////////////////////////////////////////////////////////////////
    $query = "select count(*) as qt, sum(comissao) as valor from vendas where situacao = 'p'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    ?>
    <div class="accordion-item p-3">
        <div class="d-flex justify-content-between">
            <div class="col text-start">Financeiro comissão</div>
            <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
            <div class="col text-end">R$ <?=number_format($d->valor,2,',','.')?></div>
        </div>
    </div>


    <div class="accordion-item">
        <h2 class="accordion-header" id="open_comissao_colaborador">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#close_comissao_colaborador" aria-expanded="false" aria-controls="close_comissao_colaborador">

            <div class="d-flex justify-content-between w-100 me-3">
                <div class="col text-start">Comissão por colaborador</div>
                <!-- <div class="col text-end">232</div> -->
            </div>

        </button>
        </h2>
        <div id="close_comissao_colaborador" class="accordion-collapse collapse" aria-labelledby="open_comissao_colaborador" data-bs-parent="#relatoriosEstatisticas">
        <div class="accordion-body">
            <ul class="list-group">
            <?php
            /////////////////////////////////////////////////////////////////
            $query = "select
                            a.*,
                            sum(a.comissao) as valor_total,
                            b.nome as nome_colaborador,
                            count(*) as qt
                        from vendas_produtos a
                            left join colaboradores b on a.colaborador = b.codigo
                            left join vendas c on a.venda = c.codigo
                        where c.situacao = 'p' group by a.colaborador order by a.codigo desc";
            $result = mysqli_query($con, $query);
            $n = mysqli_num_rows($result);
            while($d = mysqli_fetch_object($result)){
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?=$d->nome_colaborador?>
                    <div><?=$d->qt.(($d->qt > 1)?' Itens':' Item')?></div>
                    <span class="badge bg-primary rounded-pill">R$ <?=number_format($d->valor_total,2,',','.')?></span>
                </li>
            <?php
            }
            if(!$n){
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h4 class="w-100 text-center" style="color:#a1a1a1;">CATEGORIA SEM REGISTROS</h4>
                </li>
            <?php
            }
            ?>
            </ul>
        </div>
        </div>
    </div>


</div>


<script>
    $(function(){
        $(".relatorio").click(function(){
            $.alert('<center>Relatório não especificado,<br>aguardando informações!</center>');
        })
    })
</script>
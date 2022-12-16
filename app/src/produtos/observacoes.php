<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $query = "select * from produtos where codigo = '{$_POST['produto']}'";
    $result = mysqli_query($con, $query);
    $p = mysqli_fetch_object($result);

    // itens => Categoria para remover itens dos produtos


    if($_POST['combo'] and $p->descricao){
        $query = "select * from produtos where codigo in ({$p->descricao})";
        $result = mysqli_query($con, $query);
        $CodigosRemove = [];
        $produtos = false;
        while($p1 = mysqli_fetch_object($result)){

            $ItensDoProduto = json_decode($p1->itens);
            foreach($ItensDoProduto as $ind => $val){
                $CodigosRemove[] = $val->produto;
            }

        }

        if($CodigosRemove) $produtos = implode(", ",$CodigosRemove);

    }else{
        $ItensDoProduto = json_decode($p->itens);
        $CodigosRemove = [];
        $produtos = false;
        foreach($ItensDoProduto as $ind => $val){
            $CodigosRemove[] = $val->produto;
        }
        if($CodigosRemove) $produtos = implode(", ",$CodigosRemove);
    }


    // categorias_itens => Categorias para adicionar aos produtos
    $ItensAdicionar = json_decode($p->categorias_itens);
    $CodigosAdicionar = [];
    $produtos_adicionar = false;
    foreach($ItensAdicionar as $ind => $val){
        $CodigosAdicionar[] = $val;
    }
    if($CodigosAdicionar) $produtos_adicionar = implode(", ",$CodigosAdicionar);


    // categorias_troca => Categorias para troca dos produtos apenas nos combos
    $ItensTrocar = json_decode($p->categorias_troca);
    $CodigosTrocar = [];
    $produtos_trocar = false;
    foreach($ItensTrocar as $ind => $val){
        $CodigosTrocar[] = $val;
    }
    if($CodigosTrocar) $produtos_trocar = implode(", ", $CodigosTrocar);

?>

<style>
    .ObsTopoTitulo{
        position:fixed;
        left:0px;
        top:0px;
        width:100%;
        height:60px;
        background:#f5ebdc;
        padding-left:70px;
        padding-top:15px;
        z-index:1;
    }
</style>

<div class="ObsTopoTitulo">
    <h4>Personalizar Pedido</h4>
</div>

<div class="col">
    <div class="col" style="padding-bottom:50px;">

        <div class="mb-3">
            <h5>Incluir Observações</h5>
            <textarea class="form-control" id="observacoes"></textarea>
        </div>



        <?php
            $query = "select * from itens where situacao = '1' and deletado != '1' and codigo in (" . implode(", ", $CodigosRemove) . ")";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result)){
        ?>
        <div class="mb-3">
            <div class="card">
                <h5 class="card-header"><i class="fa-solid fa-eraser"></i> <small> Remover Itens do produto</small></h5>
                <ul class="list-group">

                <?php
                        while($d = mysqli_fetch_object($result)){
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input
                                del
                                type="checkbox"
                                class="form-check-input"
                                id="del<?=$d->codigo?>"
                                codigo="<?=$d->codigo?>"
                                descricao="<?=$d->item?>"
                                valor="<?=$d->valor?>"
                            >
                            <label class="form-check-label" for="del<?=$d->codigo?>"> <small><?=$d->item?></small></label>
                        </div>
                        <!-- <span class="badge badge-primary badge-pill">R$ <?=number_format($d->valor,2,',',false)?></span> -->
                    </li>
                    <?php
                        }

                    ?>
                </ul>
            </div>
        </div>
            <?php
                }
            ?>




        <?php
        // Substituição dos itens no combo
         if($_POST['combo']){
            $query = "select * from itens where situacao = '1' and deletado != '1' and categoria in (" . (($produtos_trocar)?:'0') . ")";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result)){
        ?>
        <div class="mb-3">
            <div class="card">
                <h5 class="card-header"><i class="fa-solid fa-eraser"></i> <small> Substituir Itens do combo</small></h5>
                <ul class="list-group">

                <?php
                        while($d = mysqli_fetch_object($result)){
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input
                                troca
                                type="radio"
                                name="trocarItens"
                                class="form-check-input"
                                id="troca<?=$d->codigo?>"
                                codigo="<?=$d->codigo?>"
                                descricao="<?=$d->item?>"
                                valor="<?=$d->valor_combo?>"
                            >
                            <label class="form-check-label" for="troca<?=$d->codigo?>"> <small><?=$d->item?></small></label>
                        </div>
                        <span class="badge badge-pill"><small>+ R$ <?=number_format($d->valor_combo,2,',',false)?></small></span>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php
            }
        }
        ?>






        <div class="mb-3">
            <div class="card">
                <h5 class="card-header"><i class="fa-solid fa-cart-plus"></i> <small> Adicionar Itens ao produto</small></h5>
                <ul class="list-group">
                    <?php
                        $query = "select
                                        a.*,
                                        b.categoria
                                from itens a
                                left join categorias_itens b on a.categoria = b.codigo

                                where
                                    b.situacao = '1' and
                                    b.deletado != '1' and
                                    a.situacao = '1' and
                                    a.deletado != '1' and
                                    a.categoria in (".(($produtos_adicionar)?:'0').")
                                order by b.categoria, a.item";
                        $result = mysqli_query($con, $query);
                        $Categoria = false;
                        while($d = mysqli_fetch_object($result)){

                            if($Categoria != $d->categoria ){
                                $Categoria = $d->categoria;
                                echo "<li class=\"list-group-item\"><b>{$Categoria}</b></li>";
                            }

                    ?>
                    <!-- d-flex justify-content-between align-items-center -->
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input
                                        add
                                        type="checkbox"
                                        class="form-check-input"
                                        id="add<?=$d->codigo?>"
                                        codigo="<?=$d->codigo?>"
                                        descricao="<?=$d->item?>"
                                        valor="<?=$d->valor?>"
                                    >
                                    <label class="form-check-label" for="add<?=$d->codigo?>"><small><?=$d->item?></small></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-3">
                                <select id="qt<?=$d->codigo?>" class="form-control form-control-sm">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <span class="badge badge-pill"> <small>R$ <?=number_format($d->valor,2,',',false)?></small></span>
                            </div>
                        </div>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>

    </div>
</div>

<div style="position:fixed; bottom:0px; left:0px; width:100%;">
    <button class="btn btn-success btn-lg btn-block" id="incluir_observacoes">Incluir Observações</button>
</div>

<script>
    $(function(){
        Carregando('none');

        $("#observacoes").val($(".observacoes").html());


        for(i=0; i < Del.length; i++){
            // console.log(Del[i].codigo)
            $(`#del${Del[i].codigo}`).prop("checked", true);
        }

        for(i=0; i < Troca.length; i++){
             //console.log('TROCA: ' + Troca[i].codigo)
            $(`#troca${Troca[i].codigo}`).prop("checked", true);
        }

        for(i=0; i < Add.length; i++){
            // console.log(Add[i].codigo)
            $(`#add${Add[i].codigo}`).prop("checked", true);
        }



        $("#incluir_observacoes").click(function(){

            $(".observacoes").html($("#observacoes").val());

            //-------
            valor_unitario = $("span[valor]").attr("atual");

            Add = [];
            $("input[add]").each(function(){
                if($(this).prop("checked") == true){
                    cd = $(this).attr('codigo');
                    qt = $(`#qt${cd}`).val();
                    Add.push({codigo:$(this).attr('codigo'), descricao:$(this).attr('descricao'), quantidade:qt, valor:$(this).attr('valor')});
                }
            });

            Troca = [];
            $("input[troca]").each(function(){
                if($(this).prop("checked") == true){
                    cd = $(this).attr('codigo');
                    Troca.push({codigo:$(this).attr('codigo'), descricao:$(this).attr('descricao'), valor:$(this).attr('valor')});
                }
            });

            Del = [];
            $("input[del]").each(function(){
                if($(this).prop("checked") == true){
                    Del.push({codigo:$(this).attr('codigo'), descricao:$(this).attr('descricao')});
                }
            });


            //--------
            var obsAdd = '';
            var valor_unitario_aditivo = 0;
            if(Add.length > 0){
                obsAdd += "<b>Adicionar os Itens no produto:</b><br>";
            }
            for(i=0; i < Add.length; i++){
                // console.log(Add[i].codigo)
                valor_unitario_aditivo = ( (valor_unitario_aditivo*1) + (Add[i].valor * Add[i].quantidade));
                VlItem = (Add[i].valor * Add[i].quantidade).toLocaleString('pt-br', {minimumFractionDigits: 2});
                obsAdd += `- ${Add[i].quantidade} x ${Add[i].descricao} + (R$ ${VlItem})<br>`;
            }


            //---------
            var obsTroca = '';
            if(Troca.length > 0){
                obsTroca += "<b>Substituição de Itens do produto:</b><br>";
            }
            for(i=0; i < Troca.length; i++){
                // console.log(Del[i].codigo)
                valor_unitario_aditivo = ( (valor_unitario_aditivo * 1) + (Troca[i].valor * 1));
                VlItem = (Troca[i].valor).toLocaleString('pt-br', {minimumFractionDigits: 2});
                obsTroca += `- ${Troca[i].descricao} + (R$ ${VlItem})<br>`;
            }

            $("span[valor]").attr("aditivo", valor_unitario_aditivo*1);

            $("span[valor]").html((valor_unitario_aditivo*1 + valor_unitario*1).toLocaleString('pt-br', {minimumFractionDigits: 2}));

            //---------
            var obsDel = '';
            if(Del.length > 0){
                obsDel += "<b>Remover os Itens do produto:</b><br>";
            }
            for(i=0; i < Del.length; i++){
                // console.log(Del[i].codigo)
                obsDel += `- ${Del[i].descricao}<br>`;
            }



            //-------
            var produto_descricao2 = '';
            produto_descricao2 += obsAdd;
            produto_descricao2 += obsTroca;
            produto_descricao2 += obsDel;
            $(".observacoes2").html(produto_descricao2);

            // console.log('Adicionados:');
            // console.log(Add);
            // console.log('Deletados:');
            // console.log(Del);
            // return false;

            PageClose();
        });

    })
</script>
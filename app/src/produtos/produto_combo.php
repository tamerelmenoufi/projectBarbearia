<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    VerificarVendaApp();

    if (isset($_POST) and $_POST['acao'] === 'adicionar_pedido') {

        if(!$_SESSION['AppVenda']){
            mysqli_query($con, "INSERT INTO vendas SET cliente = '{$_SESSION['AppCliente']}', /*mesa = '{$_SESSION['AppPedido']}',*/ data_pedido = NOW()");
            $_SESSION['AppVenda'] = mysqli_insert_id($con);
        }

        $arrayInsert = [
            'venda' => $_SESSION['AppVenda'],
            'cliente' => $_SESSION['AppCliente'],
            //'mesa' => $_SESSION['AppPedido'],
            'produto' => $_POST['produto'],
            'produto_nome' => $_POST['produto_nome'],
            'produto_descricao' => $_POST['produto_descricao'],
            'quantidade' => $_POST['quantidade'],
            'valor_unitario' => $_POST['valor_unitario'],
            // 'produto_json' => $_POST['produto_json'],
            'valor_total' => $_POST['valor_total'],
            'data' => date('Y-m-d H:i:s'),
        ];

        $attr = [];

        foreach ($arrayInsert as $key => $item) {
            $attr[] = "{$key} = '{$item}'";
        }

        if($_POST['quantidade'] < 1){
            echo json_encode([
                "status" => "erro",
            ]);
            exit();
        }

        $query = "INSERT INTO vendas_produtos SET " . implode(", ", $attr);

        if (@mysqli_query($con, $query)) {
            echo json_encode([
                "status" => "sucesso",
            ]);
            $_SESSION['AppCarrinho'] = true;
        }

        exit();
    }

    $produto = $_POST['produto'];
    $medida = $_POST['medida'];
    $valor = $_POST['valor'];

    $query = "SELECT a.*, b.categoria AS nome_categoria FROM produtos a "
        . "LEFT JOIN categorias b ON a.categoria = b.codigo "
        . "WHERE a.codigo = '{$produto}' AND a.deletado != '1' AND b.deletado != '1'";

    $result = mysqli_query($con, $query);
    $p = mysqli_fetch_object($result);


    $q = "select * from produtos where codigo in ({$p->descricao})";
    $r = mysqli_query($con, $q);
    $valor_total = 0;
    $descricao = [];
    while($v = mysqli_fetch_object($r)){

        $valor_total =  $valor_total + $v->valor_combo;
        $descricao[] = $v->descricao;

        // if($m->medida == 'COMBO'){
        //     $M[$m['codigo']] = [
        //         "ordem" => $m['ordem'],
        //         "descricao" => $m['medida']
        //     ];
        // }
    }

    list($valor,$decimal) = explode(".", $valor_total);
    $descricao = implode(" ",$descricao);

?>
<style>
    span[valor] {
        margin-left: 10px;
    }

    #quantidade {
        text-align: center;
    }

    #rotulo_valor {
        width: 180px;
        font-weight: bold;
    }

    .texto_detalhes {
        color: red;
        font-size: 12px;
    }

    .foto<?=$md5?> {
        background-size: 80%;
        background-position: center center;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        /*background-color:#f5ebdc;*/
        background-repeat:no-repeat;
        height:250px;
        position:fixed;
        z-index:2;
    }
    .foto<?=$md5?> span[sabor]{
        position:absolute;
        left:80px;
        top:20px;
        font-size:16px;
        font-weight:bold;
        color:#502314;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
    }
    .foto<?=$md5?> span[categoria]{
        position:absolute;
        right:20px;
        top:45px;
        font-size:16px;
        font-weight:bold;
        color:#333;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
        display:none;
    }
    .foto<?=$md5?> span[vl]{
        position:absolute;
        left:20px;
        bottom:0px;
        font-size:16px;
        font-weight:bold;
        color:#d62300;

    }

    .foto<?=$md5?> span[vl] sup{
        font-weight:normal;
        font-size:10px;
    }
    .foto<?=$md5?> span[vl] sub{
        font-weight:bold;
        font-size:10px;
    }


    small[valor_novo] {
        display: none;
    }

    .linha_atraves {
        text-decoration-line: line-through;
    }
    .ListaSabores{
        margin-bottom:100px;
    }
    button[observacoes]{
        z-index:99;
    }
    .observacoes{
        color:red;
        font-size:10px;
        /* text-align:justify; */
        z-index: 2;
    }
    .observacoes2{
        color:#333;
        font-size:10px;
        /* text-align:justify; */
        z-index: 2;
        margin-top:10px;
        margin-bottom:10px;
    }
</style>
<div class="col">
    <div class="row" style="margin-top:-65px; padding-bottom:60px;">
        <div class="col">

                <div class="mb-3">
                    <div class="row">


                        <div
                            style="
                                    position:fixed;
                                    left:-100%;
                                    top:-10%;
                                    width:300%;
                                    height:50%;
                                    background-color:#aa3a15;
                                    z-index:1;
                                    border-radius:100%;
                                    /*background-image:url(<?=$caminho_sis?>/painel/combos/icon/<?= $p->icon ?>);*/
                                    background-size:cover;
                                    background-position:center bottom;
                                    /*opacity:0.3;*/
                                    filter: blur(5px);
                                    text-align:center;
                                    ">
                        </div>

                        <div
                            class="col foto<?= $md5 ?>"
                            style="background-image:url(<?=$caminho_sis?>/painel/combos/icon/<?= $p->icon ?>)"
                        >
                            <span sabor><?= $p->produto ?></span>
                            <!-- <span categoria>COMBO</span> -->
                            <!-- <span vl><sub>R$</sub> <?= $valor ?><sup>,<?= str_pad($decimal , 2 , '0' , STR_PAD_RIGHT) ?></sup></span> -->
                        </div>
                    </div>
                </div>

                <div style="position:fixed; top:270px; z-index:99; width:100%;">
                    <div class="row">
                        <div class="col">
                            <div class="card-body">
                                <!-- <h5 class="card-title">
                                    <?= $p->nome_categoria ?> - <?= $p->produto ?> (<?= $m->medida ?>)
                                </h5> -->
                                <div class="row">
                                    <div class="col-8">
                                        <button observacoes class="btn btn-warning btn-block"><i class="fa-solid fa-pencil"></i> Recomendações</button>
                                    </div>
                                    <div class="col-4">
                                        <div style="text-align:right;"><small>R$</small> <small valor_atual><?= number_format($valor_total, 2, ',', '.') ?></small></div>
                                        <div style="font-size:10px; text-align:right;">Valor Cobrado</div>
                                    </div>
                                </div>


                                <div style="position:fixed; top:345px; bottom:100px; overflow:scroll; left:10px; right:10px;">
                                    <p class="observacoes"></p>
                                    <p class="observacoes2"></p>
                                    <p class="card-text"><?= $descricao ?></p>
                                </div>

                                <!-- <div class="col-md-12" style="margin-bottom:20px;">
                                    <p class="card-text texto_detalhes"></p>
                                </div>
                                <?php if ($m->qt_produtos > 1) { ?>
                                <button class="btn btn-secondary btn-block mais_sabores" style="margin-bottom:5px;">
                                    Pode adicionar até mais
                                    <?= ($m->qt_produtos - 1) . ' ' . (($m->qt_produtos == 2) ? 'sabor' : 'sabores') ?>
                                </button>
                                <div class="ListaSabores"></div>
                                <?php } ?> -->

                            </div>
                        </div>
                    </div>
                </div>

                <div style="position:fixed; bottom:0; left:0; width:100%; z-index:1; background-color:#f5ebdc;">
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <div
                                    class="btn btn-dangerX text-danger"
                                    type="button"
                                    id="menos">
                                <i class="fa-solid fa-circle-minus"></i>
                            </div>
                        </div>

                        <div
                                class="form-control"
                                id="quantidade"
                                style="border:0; background-color:#f5ebdc"
                        >1</div>

                        <div class="input-group-append">
                            <div
                                    class="btn btn-successX text-success"
                                    type="button"
                                    id="mais">
                                <i class="fa-solid fa-circle-plus"></i>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <span
                                    class="btn btn-primaryX text-primary"
                                    id="rotulo_valor">
                                R$ <span valor atual="<?=$valor_total?>" aditivo="0">
                                    <?= number_format($valor_total, 2, ',', '.') ?>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="input-group input-group-lg">
                        <button adicionar_produto class="btn btn-danger btn-lg btn-block">ADICIONAR</button>
                    </div>
                </div>



        </div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');

        var qt = 0;
        var v_produto_com_sabores = 0;

        Add = [];
        Del = [];
        Troca = [];

        $("#mais").click(function () {
            quantidade = $("#quantidade").html();
            atual = $("span[valor]").attr("atual");
            aditivo = $("span[valor]").attr("aditivo");
            quantidade = (quantidade * 1 + 1);
            $("#quantidade").html(quantidade);
            valor = (atual*1 + aditivo*1) * quantidade;
            $("span[valor]").html(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));

        });

        $("#menos").click(function () {
            quantidade = $("#quantidade").html();
            atual = $("span[valor]").attr("atual");
            aditivo = $("span[valor]").attr("aditivo");
            quantidade = ((quantidade * 1 > 1) ? (quantidade * 1 - 1) : 1);

            $("#quantidade").html(quantidade);

            valor = (atual*1 + aditivo*1) * quantidade;
            $("span[valor]").html(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));

        });


        $("button[observacoes]").click(function(){
            Carregando();
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:"src/produtos/observacoes.php",
                    produto:'<?=$p->codigo?>',
                    combo:'1'
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                }
            });
        });


        $("button[adicionar_produto]").click(function(){
            //-------
            valor_unitario = $("span[valor]").attr("atual");
            //-------
            valor_aditivo = $("span[valor]").attr("aditivo");

            //-------
            valor_unitario = (valor_unitario*1 + valor_aditivo*1);

            //-------
            quantidade = $("#quantidade").html();
            //-------
            valor_total = ((valor_unitario*1) * quantidade);
            //-------
            var produto = '<?=$p->codigo?>';
            //-------
            var produto_nome = '<?=$p->produto?>';

            //-------
            var produto_descricao = $(".observacoes2").html();

            if(quantidade < 1 || valor_total == 0 || valor_unitario == 0){
                $.alert('Ocorreu um erro, favor tente incluir novamente seu produto na lista de compras.');
                return false;
            }


            $(".IconePedidos, .MensagemAddProduto").css("display","none");
            $.ajax({
                url:"src/produtos/produto_combo.php",
                type:"POST",
                data:{
                    produto,
                    produto_nome,
                    produto_descricao,
                    valor_unitario,
                    quantidade,
                    valor_total,
                    acao:'adicionar_pedido'
                },
                success:function(dados){
                    PageClose();
                    $(".IconePedidos, .MensagemAddProduto, .IconePedidos2, .MensagemAddProduto2").css("display","block");
                    setTimeout(function(){
                        $(".MensagemAddProduto, .MensagemAddProduto2").css('display','none');
                    }, 3000);
                }
            });

        });

    })
</script>
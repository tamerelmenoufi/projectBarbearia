<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'principal'){

        mysqli_query($con, "update clientes_enderecos set padrao = '0' where cliente = '{$_SESSION['AppCliente']}'");
        $query = "update clientes_enderecos set padrao = '1' where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
        //exit();
    }

    if($_POST['acao'] == 'excluir'){

        $query = "update clientes_enderecos set deletado = '1' where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);

        //exit();
    }



?>

<style>



</style>

<style>
    .EnderecoTitulo{
        width:100%;
        position:fixed;
        padding-left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        background:#f5ebdc;
        z-index:1;
    }
    .mapa{
        width:100%;
        height:200px;
        background-color:#ccc;
    }
    .NovoEndereco{
        position:fixed;
        bottom:0px;
        right:10px;
        font-size:50px;
        color:#502314;
    }
    .SemProduto{
        position:fixed;
        top:40%;
        left:0;
        text-align:center;
        width:100%;
        color:#ccc;
    }
    .icone{
        font-size:70px;
    }
</style>
<div class="EnderecoTitulo">
    <h4>Lista de Endereços</h4>
</div>
<div class="col" style="margin-bottom:60px; margin-top:10px;">
    <div class="row">
        <div class="col-12">
            <?php
                $query = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}' and deletado != '1' order by padrao desc";
                $result = mysqli_query($con, $query);
                $n = mysqli_num_rows($result);
                while($d = mysqli_fetch_object($result)){

            ?>
            <div class="card <?=(($d->padrao)?'bg-info':false)?>" style="margin-bottom:25px; border:solid 2px #<?=(($d->padrao)?'36b9cc':'cccccc')?>;">
                <div class="card-img-top mapa" cod = '<?=$d->codigo?>'>

                </div>
                <div class="card-body">
                    <p class="card-text">
                        <div class="row <?=(($d->padrao)?'text-white':false)?>">
                            <div class="col-12">
                                <h4><?=$d->nome?></h4>
                            </div>
                            <div class="col-1">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="col-11">
                            <?php
                                echo "{$d->rua}, {$d->numero}, {$d->bairro} ".
                                (($d->complemento)?', '.$d->complemento:false).
                                (($d->referencia)?', '.$d->referencia:false);
                            ?>
                            </div>
                        </div>

                        <ul class="list-group" style="margin-top:25px;">
                            <li acao="endereco_form" cod="<?=$d->codigo?>" class="list-group-item text-primary">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-map-pin"></i></div>
                                    <div class="col-11">Editar o Endereço</div>
                                </div>
                            </li>
                            <li acao="mapa_editar" cod="<?=$d->codigo?>" class="list-group-item text-primary">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-map-location-dot"></i></div>
                                    <div class="col-11">Editar o Mapa
                                        <?php
                                        if(!$d->coordenadas){
                                        ?>
                                        <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                        <?php
                                        }else{
                                        ?>
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li padrao cod="<?=$d->codigo?>" class="list-group-item text-primary">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-location-crosshairs"></i></div>
                                    <div class="col-11">Definir endereço para entrega</div>
                                </div>
                            </li>
                            <li excluir cod="<?=$d->codigo?>" class="list-group-item text-danger">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-trash-can"></i></div>
                                    <div class="col-11">Excluir Endereço</div>
                                </div>
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
            <?php
                }
            ?>
            <div class="SemProduto" style="display:<?=(($n)?'none':'block')?>">
                <i class="fa-solid fa-face-frown icone"></i>
                <p>Poxa, ainda não tem endereços cadastrados!</p>
            </div>
        </div>
    </div>
</div>

<div class="NovoEndereco">
    <i class="fa-solid fa-circle-plus"></i>
</div>

<script>

    $(function(){

        ViewMap = (p, e, obj) => {
            $.ajax({
                url:"src/cliente/mapa_visualizar.php",
                type:"POST",
                data:{
                    p,
                    e
                },
                success:function(dados){
                    obj.html(dados);
                }

            })
        }

        $(".mapa").each(function(p){
            obj = $(this);
            e = $(this).attr("cod");
            ViewMap(p, e, obj);
        });


        $(".NovoEndereco").click(function(){
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:'src/cliente/endereco_form.php',
                },
                success:function(dados){
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });


        $("li[acao]").click(function(){
            acao = $(this).attr("acao");
            cod = $(this).attr("cod");
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:`src/cliente/${acao}.php`,
                    cod
                },
                success:function(dados){
                    $("body").attr("retorno","src/cliente/enderecos.php");
                    //PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

        $("li[padrao]").click(function(){
            cod = $(this).attr("cod");
            $.confirm({
                content:"Confirma esse endereço para as próximas entregas?",
                title:false,
                buttons:{
                    'SIM':function(){

                        $.ajax({
                            url:"componentes/ms_popup_100.php",
                            type:"POST",
                            data:{
                                local:`src/cliente/enderecos.php`,
                                cod,
                                acao:'principal'
                            },
                            success:function(dados){
                                PageClose();
                                $(".ms_corpo").append(dados);
                            }
                        });

                    },
                    'NÃO':function(){

                    }
                }
            });

        });


        $("li[excluir]").click(function(){
            cod = $(this).attr("cod");
            $.confirm({
                content:"Deseja realmente excluir o endereço?",
                title:false,
                buttons:{
                    'SIM':function(){

                        $.ajax({
                            url:"componentes/ms_popup_100.php",
                            type:"POST",
                            data:{
                                local:`src/cliente/enderecos.php`,
                                cod,
                                acao:'excluir'
                            },
                            success:function(dados){
                                PageClose();
                                $(".ms_corpo").append(dados);
                            }
                        });

                    },
                    'NÃO':function(){

                    }
                }
            });

        });



    })


</script>
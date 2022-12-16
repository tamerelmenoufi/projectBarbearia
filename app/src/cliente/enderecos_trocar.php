<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'principal'){

        mysqli_query($con, "update clientes_enderecos set padrao = '0' where cliente = '{$_SESSION['AppCliente']}'");
        $query = "update clientes_enderecos set padrao = '1' where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
        exit();
    }

?>

<style>



</style>

<style>
    .EnderecoTitulo{
        position:relative;
        width:100%;
        text-align:center;
    }
    .NovoEndereco{
        position:fixed;
        bottom:0px;
        right:10px;
        font-size:50px;
        color:#502314;
    }
</style>
<div class="EnderecoTitulo">
    <h4>Lista de Endereços</h4>
</div>
<div class="col">
    <div class="row">
        <div class="col-12">
            <?php
                $query = "select * from clientes_enderecos where cliente = '{$_SESSION['AppCliente']}' and deletado != '1' order by padrao desc";
                $result = mysqli_query($con, $query);
                $n = mysqli_num_rows($result);
                while($d = mysqli_fetch_object($result)){

            ?>
            <div class="card <?=(($d->padrao)?'bg-info':false)?>" style="margin-bottom:10px; border:solid 2px #<?=(($d->padrao)?'36b9cc':'cccccc')?>;">
                <div class="card-img-top mapa" cod = '<?=$d->codigo?>'>

                </div>
                <div class="card-body">
                    <p class="card-text">
                        <div padrao cod="<?=$d->codigo?>" class="row <?=(($d->padrao)?'text-white':false)?>">
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
                    </p>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <br><br><br>
</div>

<div class="NovoEndereco">
    <i class="fa-solid fa-circle-plus"></i>
</div>

<script>

    $(function(){

        Carregando('none');
        $(".NovoEndereco").click(function(){
            Carregando();
            $.ajax({
                url:"componentes/ms_popup_100.php",
                type:"POST",
                data:{
                    local:'src/cliente/endereco_form.php',
                },
                success:function(dados){
                    PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

        $("div[padrao]").click(function(){
            cod = $(this).attr("cod");
            $.confirm({
                content:"Confirma esse endereço para a próxima entrega?",
                title:false,
                buttons:{
                    'SIM':function(){
                        Carregando();
                        $.ajax({
                            url:"src/cliente/enderecos_trocar.php",
                            type:"POST",
                            data:{
                                cod,
                                acao:'principal'
                            },
                            success:function(dados){
                                $.ajax({
                                    url:"componentes/ms_popup_100.php",
                                    type:"POST",
                                    data:{
                                        local:"src/produtos/pagar.php",
                                    },
                                    success:function(dados){
                                        PageClose(2);
                                        $(".ms_corpo").append(dados);
                                    }
                                });
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
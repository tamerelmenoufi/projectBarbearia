<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'delete'){
        $query = "delete from clientes_enderecos where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
    }


    if($_POST['acao'] == 'insert'){
        $query = "insert into clientes_enderecos set titulo = '{$_POST['titulo']}', cliente = '{$_POST['cliente']}', data_cadastro = NOW()";
        mysqli_query($con, $query);
    }


    $query = "select * from clientes_enderecos where cliente = '{$_POST['cliente']}'";
    $result = mysqli_query($con, $query);
?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }

    .verde{
        color:green;
        cursor:pointer;
    }
    .vermelho{
        color:red;
        cursor:pointer;
    }
    .bloqueio{
        color:#eee;
    }
</style>
<h4 class="Titulo<?=$md5?>">Lista de Endereços</h4>
<div class="input-group mt-3 mb-3">
  <input type="text" class="form-control" id="titulo" placeholder="Digite o nome do Endereço" aria-label="Informe o título de seu novo endereço">
  <button class="btn btn-success novo" type="button"><i class="fa fa-file"></i> Novo Endereço</button>
</div>

<!-- <button class="btn btn-success novo mt-3 mb-3">
    <i class="fa fa-file"></i> Novo Tópico
</button> -->

<ul class="list-group">
<?php
    while($d = mysqli_fetch_object($result)){

        if(
            !$d->cep or
            !$d->rua or
            !$d->numero or
            !$d->bairro
        ){
            $blq = true;
        }else{
            $blq = false;
        }


?>
    <li class="list-group-item opc" style="display: flex; justify-content: space-between;">
        <div class="<?=(($blq)?false:'titulo')?>" cod="<?=$d->codigo?>">
            <i class="<?=(($blq)?'bloqueio ':false)?>fa-solid fa-location-<?=(($d->validacao)?'dot verde':'pin-lock vermelho')?>"></i> <?=$d->titulo?>
        </div>
        <div>
            <button class="btn btn-primary btn-sm editar" cod="<?=$d->codigo?>"><i class="fa-regular fa-pen-to-square"></i></button>
            <button class="btn btn-danger btn-sm excluir" cod="<?=$d->codigo?>"><i class="fa-solid fa-trash-can"></i></button>
        </div>
    </li>
<?php
    }
?>
</ul>
<script>
    $(function(){

        Carregando('none');

        $("button.novo").click(function(){
            titulo = $("#titulo").val();
            if(titulo){
                $("#titulo").val('');
                $.ajax({
                    url:"src/clientes/enderecos.php",
                    type:"POST",
                    data:{
                        cliente:'<?=$_POST['cliente']?>',
                        titulo,
                        acao:'insert',
                    },
                    success:function(dados){
                        $(".LateralDireita").html(dados);
                    }
                });
            }

        });


        $("button.editar").click(function(){
            cod = $(this).attr("cod");
            $.ajax({
                url:"src/clientes/enderecos_form.php",
                type:"POST",
                data:{
                    cod,
                    cliente:'<?=$_POST['cliente']?>',
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });


        $("button.excluir").click(function(){
            cod = $(this).attr("cod");
            titulo = $(this).parent("div").parent("li").children("div.titulo").text();

            // $.alert(cod);
            $.confirm({
                content:`Deseja realmente excluir o endereço:<br><b>${titulo}</b>?`,
                title:false,
                type:'red',
                buttons:{
                    'SIM':{
                        text:'<i class="fa-solid fa-trash-can"></i> SIM',
                        btnClass:'btn btn-danger',
                        action:function(){
                            $.ajax({
                                url:"src/clientes/enderecos.php",
                                type:"POST",
                                data:{
                                    cod,
                                    cliente:'<?=$_POST['cliente']?>',
                                    acao:'delete',
                                },
                                success:function(dados){
                                    $(".LateralDireita").html(dados);
                                }
                            });
                        }
                    },
                    'NÃO':{
                        text:'<i class="fa-solid fa-check"></i> NÃO',
                        btnClass:'btn btn-success',
                        action:function(){

                        }
                    }
                }
            })


        });

        $(".titulo").click(function(){
            cod = $(this).attr("cod");
            $.ajax({
                url:"src/clientes/editar_endereco.php",
                type:"POST",
                data:{
                    cod,
                    cliente:'<?=$_POST['cliente']?>',
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });

        });

    })
</script>
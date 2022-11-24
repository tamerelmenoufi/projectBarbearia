<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'delete'){
        $query = "delete from clientes_enderecos where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
    }


    if($_POST['acao'] == 'insert'){
        $query = "insert into clientes_enderecos set titulo = '{$_POST['titulo']}', cliente = '{$_POST['cliente']}'";
        mysqli_query($con, $query);
    }


    echo $query = "select * from clientes_enderecos where cliente = '{$_POST['cliente']}'";
    $result = mysqli_query($con, $query);
?>


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
?>
    <li class="list-group-item opc" style="display: flex; justify-content: space-between;">
        <div class="titulo"><?=$d->titulo?></div>
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
                        $("#home-tab-pane").html(dados);
                    }
                });
            }

        });


        $("button.editar").click(function(){
            opc = $(this).attr("cod");

            $.ajax({
                url:"src/clientes/enderecos_form.php",
                type:"POST",
                data:{
                    cod:'<?=$_POST['cod']?>',
                    opc
                },
                success:function(dados){
                    $("#home-tab-pane").html(dados);
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
                                    acao:'delete',
                                },
                                success:function(dados){
                                    $("#home-tab-pane").html(dados);
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

    })
</script>
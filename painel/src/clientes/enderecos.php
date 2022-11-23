<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/portal/painel/lib/includes.php");

    if($_POST['acao'] == 'delete'){
        $query = "update paginas_topicos set topicos = JSON_REMOVE(topicos, '$.titulo[{$_POST['opc']}]'), topicos = JSON_REMOVE(topicos, '$.descricao[{$_POST['opc']}]') where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
    }


    if($_POST['acao'] == 'insert'){
        $query = "update paginas_topicos set topicos = JSON_MERGE(topicos, '".json_encode(['titulo' => $_POST['titulo'], 'descricao' => ''], JSON_UNESCAPED_UNICODE)."') where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
    }


    $query = "select * from paginas_topicos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $topicos = json_decode($d->topicos);




?>


<div class="input-group mt-3 mb-3">
  <input type="text" class="form-control" id="titulo_topico" placeholder="Digite o título do Tópico" aria-label="Informe o título de novo tópico que deseja cadastrar">
  <button class="btn btn-success novo" type="button"><i class="fa fa-file"></i> Novo Tópico</button>
</div>

<!-- <button class="btn btn-success novo mt-3 mb-3">
    <i class="fa fa-file"></i> Novo Tópico
</button> -->

<ul class="list-group">
<?php
    foreach($topicos->titulo as $i => $val){
?>
    <li class="list-group-item opc" style="display: flex; justify-content: space-between;">
        <div class="titulo"><?=$val?></div>
        <div>
            <button class="btn btn-primary btn-sm editar" cod="<?=$i?>"><i class="fa-regular fa-pen-to-square"></i></button>
            <button class="btn btn-danger btn-sm excluir" cod="<?=$i?>"><i class="fa-solid fa-trash-can"></i></button>
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
            titulo = $("#titulo_topico").val();
            if(titulo){
                $("#titulo_topico").val('');
                $.ajax({
                    url:"src/paginas_topicos/topicos.php",
                    type:"POST",
                    data:{
                        cod:'<?=$_POST['cod']?>',
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
                url:"src/paginas_topicos/topicos_form.php",
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
            topico = $(this).parent("div").parent("li").children("div.titulo").text();

            // $.alert(cod);
            $.confirm({
                content:`Deseja realmente excluir o tópico:<br><b>${topico}</b>?`,
                title:false,
                type:'red',
                buttons:{
                    'SIM':{
                        text:'<i class="fa-solid fa-trash-can"></i> SIM',
                        btnClass:'btn btn-danger',
                        action:function(){
                            $.ajax({
                                url:"src/paginas_topicos/topicos.php",
                                type:"POST",
                                data:{
                                    cod:'<?=$_POST['cod']?>',
                                    opc:cod,
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
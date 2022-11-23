<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/portal/painel/lib/includes.php");



    if($_POST['acao'] == 'salvar'){

        $dados = $_POST;
        unset($dados['acao']);
        unset($dados['codigo']);

        $campos = [];
        foreach($dados as $i => $v){
          $campos[] = "{$i} = '{$v}'";
        }

        $query = "UPDATE paginas_topicos set
                    topicos = JSON_SET(topicos,'$.titulo[{$_POST['opc']}]','".addslashes($_POST['titulo'])."'),
                    topicos = JSON_SET(topicos,'$.descricao[{$_POST['opc']}]','".addslashes($_POST['descricao'])."')
                WHERE codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        $acao = mysqli_affected_rows($con);

        if($acao){
          echo "Atualização realizada com sucesso!";
        }else{
          echo "Nenhuma alteração foi registrada!";
        }

        exit();


    }





    $query = "select * from paginas_topicos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $topicos = json_decode($d->topicos);

    // print_r($_POST);
    // echo "<hr>";
    // print_r($topicos);

    // echo "<hr>";
    // echo "Título: ".$topicos->titulo[$_POST['opc']];
    // echo "<br>";
    // echo "Descrição: ".$topicos->descricao[$_POST['opc']];

    // echo "<br><br><br>";

?>

<form id="acaoMenu">

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="titulo_topico" name="titulo" placeholder="Título da Página" value="<?=$topicos->titulo[$_POST['opc']]?>">
  <label for="titulo_topico">Título do Tópico</label>
  <div class="form-text">Digite o nome do tópico que aparecerá no site.</div>
</div>

<div class="form-floating mb-3">
  <textarea class="form-control" style="height:100px;" id="descricao_topico" name="descricao" placeholder="Descrição do tópico"><?=$topicos->descricao[$_POST['opc']]?></textarea>
  <label for="descricao_topico">Descrição do Tópico</label>
  <div class="form-text">Digite a descrição do Tópico.</div>
</div>

<button type="submit" class="btn btn-primary mt-3"> <i class="fa fa-save"></i> Salvar Dados</button>
<button type="button" class="btn btn-danger mt-3 voltar"> <i class="fa fa-cancel"></i> Cancelar</button>

<input type="hidden" id="acao" name="acao" value="salvar" >
<input type="hidden" id="codigo" name="codigo" value="<?=$d->codigo?>" >
<input type="hidden" id="opc" name="opc" value="<?=$_POST['opc']?>" >
</form>



<script>
    $(function(){

        Carregando('none');


        $( "form" ).on( "submit", function( event ) {

            data = [];

            event.preventDefault();

            data = $( this ).serialize();

            $.ajax({
                url:"src/paginas_topicos/topicos_form.php",
                type:"POST",
                data,
                success:function(dados){

                    $.alert({
                    content:dados,
                    type:"orange",
                    title:false,
                    buttons:{
                        'ok':{
                        text:'<i class="fa-solid fa-check"></i> OK',
                        btnClass:'btn btn-warning'
                        }
                    }
                    });

                    $.ajax({
                        url:"src/paginas_topicos/topicos.php",
                        type:"POST",
                        data:{
                            cod:'<?=$_POST['cod']?>'
                        },
                        success:function(dados){
                            $("#home-tab-pane").html(dados);
                        }
                    });

                }
            });
        });


        $("button.voltar").click(function(){

            $.ajax({
                url:"src/paginas_topicos/topicos.php",
                type:"POST",
                data:{
                    cod:'<?=$_POST['cod']?>'
                },
                success:function(dados){
                    $("#home-tab-pane").html(dados);
                }
            });

        });

    })
</script>
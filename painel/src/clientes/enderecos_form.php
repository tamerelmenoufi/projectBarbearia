<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'salvar'){

        $dados = $_POST;
        unset($dados['acao']);
        unset($dados['codigo']);

        $campos = [];
        foreach($dados as $i => $v){
          $campos[] = "{$i} = '{$v}'";
        }

        if($campos) $campos = implode(", ",$campos);

        $query = "update clientes_enderecos set {$campos} where codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        $acao = mysqli_affected_rows($con);
        $cod = $_POST['codigo'];

        if($acao){
          echo $query. "Atualização realizada com sucesso!";
        }else{
          echo $query. "Nenhuma alteração foi registrada!";
        }

        exit();


    }





    $query = "select * from clientes_enderecos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>

<form id="acaoMenu">

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título da Página" value="<?=$d->titulo?>">
  <label for="titulo">Título do Endereço</label>
  <div class="form-text">Digite o nome de identificação do endereço.</div>
</div>

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="cep" name="cep" placeholder="Título da Página" value="<?=$d->cep?>">
  <label for="cep">CEP</label>
  <div class="form-text">Digite o CEP do endereço</div>
</div>

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="rua" name="rua" placeholder="Título da Página" value="<?=$d->rua?>">
  <label for="rua">Rua</label>
  <div class="form-text">Digite o nome da Rua</div>
</div>

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="numero" name="numero" placeholder="Título da Página" value="<?=$d->numero?>">
  <label for="numero">Número</label>
  <div class="form-text">Informe o número da Casa / condomínio</div>
</div>

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Título da Página" value="<?=$d->bairro?>">
  <label for="bairro">Bairro</label>
  <div class="form-text">Informe o nome do Bairro</div>
</div>

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Título da Página" value="<?=$d->complemento?>">
  <label for="complemento">Complemento</label>
  <div class="form-text">Quadra, bloco, apartamento, ect</div>
</div>

<div class="form-floating mb-3">
  <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Título da Página" value="<?=$d->referencia?>">
  <label for="referencia">Ponto de Referência</label>
  <div class="form-text">Informe um local de referência para o seu endereço</div>
</div>

<button type="submit" class="btn btn-primary mt-3"> <i class="fa fa-save"></i> Salvar Dados</button>
<button type="button" class="btn btn-danger mt-3 voltar"> <i class="fa fa-cancel"></i> Cancelar</button>

<input type="hidden" id="acao" name="acao" value="salvar" >
<input type="hidden" id="codigo" name="codigo" value="<?=$d->codigo?>" >
<input type="hidden" id="cliente" name="cliente" value="<?=$d->cliente?>" >
</form>



<script>
    $(function(){

        Carregando('none');


        $( "form" ).on( "submit", function( event ) {

            data = [];

            event.preventDefault();

            data = $( this ).serialize();

            $.ajax({
                url:"src/clientes/enderecos_form.php",
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
                        url:"src/clientes/enderecos.php",
                        type:"POST",
                        data:{
                            cod:'<?=$_POST['cod']?>',
                            cliente:'<?=$_POST['cliente']?>',
                        },
                        success:function(dados){
                            $(".LateralDireita").html(dados);
                        }
                    });

                }
            });
        });


        $("button.voltar").click(function(){

            $.ajax({
                url:"src/clientes/enderecos.php",
                type:"POST",
                data:{
                    cod:'<?=$_POST['cod']?>',
                    cliente:'<?=$_POST['cliente']?>',
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });

        });

    })
</script>
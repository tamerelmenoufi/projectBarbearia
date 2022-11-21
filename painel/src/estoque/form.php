<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'salvar'){

      $dados = $_POST;
      unset($dados['acao']);
      unset($dados['codigo']);

      //nota
      $img = false;
      unset($dados['base64']);
      unset($dados['nota_tipo']);
      unset($dados['nota_nome']);

      if($_POST['base64'] and $_POST['nota_tipo'] and $_POST['nota_nome']){

        if($_POST['nota']) unlink("../volume/estoque/{$_POST['nota']}");

        $base64 = explode('base64,', $_POST['base64']);
        $img = base64_decode($base64[1]);
        $ext = substr($_POST['nota_nome'], strripos($_POST['nota_nome'],'.'), strlen($_POST['nota_nome']));
        $nome = md5($_POST['base64'].$_POST['nota_tipo'].$_POST['nota_nome']).$ext;

        $exts = [
          '.pdf',
          '.jpg',
          '.jpeg',
          '.png',
          '.gif'
        ];
        if(!in_array($exts, strtolower($ext))){
          echo "Documento anexo inválido!";
          exit();
        }

        if(!is_dir("../volume/estoque")) mkdir("../volume/estoque");
        if(file_put_contents("../volume/estoque/".$nome, $img)){
          $dados['nota'] = $nome;
        }
      }
      //Fim da Verificação da nota


      $campos = [];
      foreach($dados as $i => $v){
        $campos[] = "{$i} = '{$v}'";
      }
      if($_POST['codigo']){
        $query = "UPDATE produtos_estoque set ".implode(", ",$campos)." WHERE codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        $acao = mysqli_affected_rows($con);
      }else{
        $query = "INSERT INTO produtos_estoque set ".implode(", ",$campos)."";
        mysqli_query($con, $query);
        $acao = mysqli_affected_rows($con);
      }

      if($acao){
        echo "Atualização realizada com sucesso!";
      }else{
        echo "Nenhuma alteração foi registrada!";
      }

      exit();


    }


    if($_POST['cod']){
      $query = "select * from produtos_estoque where codigo = '{$_POST['cod']}'";
      $result = mysqli_query($con, $query);
      $d = mysqli_fetch_object($result);
    }

?>
<style>
  .titulo<?=$md5?>{
    position:fixed;
    top:7px;
    margin-left:50px;
  }
</style>

<h3 class="titulo<?=$md5?>">Editar Estoque</h3>

    <form id="acaoMenu">
      <h5><?=$_SESSION['ProdutoNome']?></h5>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título do Estoque" value="<?=$d->titulo?>">
        <label for="titulo">Título de Identificação</label>
        <div class="form-text">Digite o título do lançamento do estoque.</div>
      </div>

      <div class="form-floating mb-3">
        <input type="datetime-local" class="form-control" id="data_cadastro" name="data_cadastro" placeholder="Data do comprovante" value="<?=$d->data_cadastro?>">
        <label for="data_cadastro">Data</label>
        <div class="form-text">Informe a data do comprovante.</div>
      </div>

      <div class="form-floating mb-3">
        <input type="number" class="form-control" id="estoque" name="estoque" placeholder="Quantidade de Itens" value="<?=$d->estoque?>">
        <label for="estoque">Quantidade de Itens</label>
        <div class="form-text">Informe a quantidade de itens.</div>
      </div>

      <div showImage class="form-floating" style="display:<?=(($d->nota)?'block':'none')?>">
        <!-- <img src="<?=$localPainel?>src/volume/estoque/<?=$d->nota?>" class="img-fluid mt-3 mb-3" alt="" /> -->
        <object data="<?=$localPainel?>src/volume/estoque/<?=$d->nota?>" class="img-fluid mt-3 mb-3"></object>
      </div>

      <!-- <div class="form-floating"> -->
        <input type="file" class="form-control" placeholder="Banner" accept="application/pdf,image/*">
        <input type="hidden" id="base64" name="base64" value="" />
        <input type="hidden" id="nota_tipo" name="nota_tipo" value="" />
        <input type="hidden" id="nota_nome" name="nota_nome" value="" />
        <input type="hidden" id="nota" name="nota" value="<?=$d->nota?>" />
        <!-- <label for="url">Banner</label> -->
        <div class="form-text mb-3">Selecione a nota para o Banner</div>
      <!-- </div> -->

      <button type="submit" data-bs-dismiss="offcanvas" class="btn btn-primary mt-3"> <i class="fa fa-save"></i> Salvar Dados</button>
      <button cancelar type="button" data-bs-dismiss="offcanvas" class="btn btn-danger mt-3"> <i class="fa fa-cancel"></i> Cancelar</button>

      <input type="hidden" id="acao" name="acao" value="salvar" >
      <input type="hidden" id="codigo" name="codigo" value="<?=$d->codigo?>" >
      <input type="hidden" id="tipo" name="tipo" value="<?=(($d->tipo)?:'e')?>" >
      <input type="hidden" id="produto" name="produto" value="<?=(($d->produto)?:$_SESSION['codProduto'])?>" >
    </form>

<script>

    // ClassicEditor
    // .create( document.querySelector( '#materia' ) )
    // .then( editor => {
    //     console.log( editor );
    // } )
    // .catch( error => {
    //     console.error( error );
    // } );

// console.log(editor);

    $(function(){

      Carregando('none');


      $( "form" ).on( "submit", function( event ) {

        event.preventDefault();
        // materia = editor.getData();
        data = $( this ).serialize();
        // data.push({name:'materia', value:editor});
        console.log(data);

        $.ajax({
          url:"src/estoque/form.php",
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

            $("div[lista]").html('');
            $.ajax({
              url:"src/estoque/lista.php",
              success:function(dados){
                  $("#paginaHome").html(dados);
              }
            });

          }
        });
      });





      if (window.File && window.FileList && window.FileReader) {

        $('input[type="file"]').change(function () {

            if ($(this).val()) {
                var files = $(this).prop("files");
                for (var i = 0; i < files.length; i++) {
                    (function (file) {
                        var fileReader = new FileReader();
                        fileReader.onload = function (f) {


                        var Base64 = f.target.result;
                        var type = file.type;
                        var name = file.name;

                        $("#base64").val(Base64);
                        $("#nota_tipo").val(type);
                        $("#nota_nome").val(name);

                        $("div[showImage] object").attr("data",Base64);
                        $("div[showImage]").css("display",'block');



                        };
                        fileReader.readAsDataURL(file);
                    })(files[i]);
                }
          }
        });
      } else {
        alert('Nao suporta HTML5');
      }




    })
</script>
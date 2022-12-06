<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    if($_POST['acao'] == 'salvar'){

      $dados = $_POST;
      unset($dados['acao']);
      unset($dados['codigo']);

      //Imagem
      $img = false;
      unset($dados['base64']);
      unset($dados['imagem_tipo']);
      unset($dados['imagem_nome']);

      if($_POST['base64'] and $_POST['imagem_tipo'] and $_POST['imagem_nome']){

        if($_POST['imagem']) unlink("../volume/produtos_categorias/{$_POST['imagem']}");

        $base64 = explode('base64,', $_POST['base64']);
        $img = base64_decode($base64[1]);
        $ext = substr($_POST['imagem_nome'], strripos($_POST['imagem_nome'],'.'), strlen($_POST['imagem_nome']));
        $nome = md5($_POST['base64'].$_POST['imagem_tipo'].$_POST['imagem_nome'].date("YmdHis")).$ext;

        if(!is_dir("../volume/produtos_categorias")) mkdir("../volume/produtos_categorias");
        if(file_put_contents("../volume/produtos_categorias/".$nome, $img)){
          $dados['imagem'] = $nome;
        }
      }
      //Fim da Verificação da Imagem


      $campos = [];
      foreach($dados as $i => $v){
        $campos[] = "{$i} = '{$v}'";
      }
      if($_POST['codigo']){
        $query = "UPDATE produtos_categorias set ".implode(", ",$campos)." WHERE codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        $acao = mysqli_affected_rows($con);
      }else{
        $query = "INSERT INTO produtos_categorias set ".implode(", ",$campos)."";
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
      $query = "select * from produtos_categorias where codigo = '{$_POST['cod']}'";
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

<h3 class="titulo<?=$md5?>">Gerenciamento de Notícias</h3>

    <form id="acaoMenu">

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Título do Banner" value="<?=$d->categoria?>">
        <label for="categoria">Categoria</label>
        <div class="form-text">Digite o título da Categoria.</div>
      </div>

      <div showImage class="form-floating" style="display:<?=(($d->imagem)?'block':'none')?>">
        <img src="<?=$localPainel?>src/volume/produtos_categorias/<?=$d->imagem?>" class="img-fluid mt-3 mb-3" alt="" />
      </div>

      <!-- <div class="form-floating"> -->
        <input type="file" class="form-control" placeholder="Banner">
        <input type="hidden" id="base64" name="base64" value="" />
        <input type="hidden" id="imagem_tipo" name="imagem_tipo" value="" />
        <input type="hidden" id="imagem_nome" name="imagem_nome" value="" />
        <input type="hidden" id="imagem" name="imagem" value="<?=$d->imagem?>" />
        <!-- <label for="url">Banner</label> -->
        <div class="form-text mb-3">Selecione a imagem para o Banner</div>
      <!-- </div> -->


      <div class="form-floating">
        <select id="situacao" name="situacao" class="form-control" placeholder="Situação">
          <option value="1" <?=(($d->situacao == '1')?'selected':false)?>>Liberado</option>
          <option value="0" <?=(($d->situacao == '0')?'selected':false)?>>Bloqueado</option>
        </select>
        <label for="situacao">Imagem</label>
        <div class="form-text">Selecione a imagem para a categoria</div>
      </div>




      <button type="submit" data-bs-dismiss="offcanvas" class="btn btn-primary mt-3"> <i class="fa fa-save"></i> Salvar Dados</button>
      <button cancelar type="button" data-bs-dismiss="offcanvas" class="btn btn-danger mt-3"> <i class="fa fa-cancel"></i> Cancelar</button>

      <input type="hidden" id="acao" name="acao" value="salvar" >
      <input type="hidden" id="codigo" name="codigo" value="<?=$d->codigo?>" >
    </form>

<script>

    ClassicEditor
    .create( document.querySelector( '#materia' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

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
          url:"src/produtos_categorias/form.php",
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
              url:"src/produtos_categorias/lista.php",
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
                        $("#imagem_tipo").val(type);
                        $("#imagem_nome").val(name);

                        $("div[showImage] img").attr("src",Base64);
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
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

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

        if($_POST['imagem']) unlink("../volume/portifolio/{$_POST['imagem']}");

        $base64 = explode('base64,', $_POST['base64']);
        $img = base64_decode($base64[1]);
        $ext = substr($_POST['imagem_nome'], strripos($_POST['imagem_nome'],'.'), strlen($_POST['imagem_nome']));
        $nome = md5($_POST['base64'].$_POST['imagem_tipo'].$_POST['imagem_nome']).$ext;

        if(!is_dir("../volume/portifolio")) mkdir("../volume/portifolio");
        if(file_put_contents("../volume/portifolio/".$nome, $img)){
          $dados['imagem'] = $nome;
        }
      }
      //Fim da Verificação da Imagem


      $campos = [];
      foreach($dados as $i => $v){
        $campos[] = "{$i} = '{$v}'";
      }
      if($_POST['codigo']){
        $query = "UPDATE portifolio_categorias set ".implode(", ",$campos)." WHERE codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        $acao = mysqli_affected_rows($con);
      }else{
        $query = "INSERT INTO portifolio_categorias set ".implode(", ",$campos)."";
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
      $query = "select * from portifolio_categorias where codigo = '{$_POST['cod']}'";
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

<h3 class="titulo<?=$md5?>">Categorias de Experiências</h3>

    <form id="acaoMenu">

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título do Serviço" value="<?=$d->titulo?>">
        <label for="titulo">Título</label>
        <div class="form-text">Digite o título do Serviço.</div>
      </div>

      <div class="form-floating mb-3">
        <!-- <textarea id="materia" name="materia"><?=$d->descricao?></textarea> -->
        <!-- <label for="materia">Matéria</label> -->
        <!-- <div class="form-text">Digite o conteúdo da Matéria.</div> -->
        <textarea id="descricao" name="descricao"><?=$d->descricao?></textarea>

      </div>


      <div class="form-floating">
        <select id="situacao" name="situacao" class="form-control" placeholder="Situação">
          <option value="1" <?=(($d->situacao == '1')?'selected':false)?>>Liberado</option>
          <option value="0" <?=(($d->situacao == '0')?'selected':false)?>>Bloqueado</option>
        </select>
        <label for="situacao">Situação</label>
        <div class="form-text">Selecione a situação da publicação</div>
      </div>


      <button type="submit" data-bs-dismiss="offcanvas" class="btn btn-primary mt-3"> <i class="fa fa-save"></i> Salvar Dados</button>
      <button cancelar type="button" data-bs-dismiss="offcanvas" class="btn btn-danger mt-3"> <i class="fa fa-cancel"></i> Cancelar</button>

      <input type="hidden" id="acao" name="acao" value="salvar" >
      <input type="hidden" id="codigo" name="codigo" value="<?=$d->codigo?>" >
    </form>

<script>

    ClassicEditor
    .create( document.querySelector( '#descricao' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

// console.log(editor);

    $(function(){




      Carregando('none');

      // $("#acaoMenu button[cancelar]").click(function(){
      //   $("div[formBanners]").html('');
      // })


      $( "form" ).on( "submit", function( event ) {

        event.preventDefault();
        // materia = editor.getData();
        data = $( this ).serialize();
        // data.push({name:'materia', value:editor});
        console.log(data);

        $.ajax({
          url:"src/portifolio/form_categorias.php",
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
              url:"src/portifolio/lista_categorias.php",
              success:function(dados){
                  // $("div[lista]").html(dados);
                  $("#paginaHome").html(dados);
              }
            });

          }
        });
      });




    })
</script>
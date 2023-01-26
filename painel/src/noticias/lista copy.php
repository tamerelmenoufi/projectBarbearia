<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['delete']){
        if($_POST['imagem']){
            unlink("../volume/noticias/".$_POST['imagem']);
        }
        $query = "delete from noticias where codigo = '{$_POST['delete']}'";
        mysqli_query($con, $query);
      }

      if($_POST['situacao']){
        // mysqli_query($con, "update noticias set situacao = '0'");
        $query = "update noticias set situacao = '{$_POST['opc']}' where codigo = '{$_POST['situacao']}'";
        mysqli_query($con, $query);
        exit();
      }


?>
<style>



</style>



<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Lista de Notícias</h5>
          <div class="card-body">
            <div style="display:flex; justify-content:end">
                <button
                    novoCadastro
                    class="btn btn-success"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasDireita"
                    role="button"
                    aria-controls="offcanvasDireita"
                ><i class="fa-regular fa-file"></i> Novo</button>
            </div>


            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col" style="width:100%">Título</th>
                  <th scope="col">Situação</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = "select * from noticias order by titulo asc";
                  $result = mysqli_query($con, $query);
                  while($d = mysqli_fetch_object($result)){
                ?>
                <tr>
                  <td style="white-space: nowrap;"><?=$d->titulo?></td>
                  <td style="white-space: nowrap;">

                  <div class="form-check form-switch">
                    <input class="form-check-input situacao" type="checkbox" <?=(($d->situacao)?'checked':false)?> situacao="<?=$d->codigo?>">
                  </div>

                  </td>
                  <td style="white-space: nowrap;">
                    <button
                      class="btn btn-primary btn-sm"
                      edit="<?=$d->codigo?>"
                      data-bs-toggle="offcanvas"
                      href="#offcanvasDireita"
                      role="button"
                      aria-controls="offcanvasDireita"
                    >
                    <i class="fa-regular fa-pen-to-square"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-sm" delete="<?=$d->codigo?>" imagem="<?=$d->imagem?>">
                    <i class="fa-solid fa-trash-can"></i> Excluir
                    </button>
                  </td>
                </tr>
                <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
    /*
?>

<div style="display: flex; justify-content: space-between;">
    <a>Lista de Banners</a>
    <button
        acaoBanner
        data-bs-toggle="offcanvas"
        href="#offcanvasDireita"
        role="button"
        aria-controls="offcanvasDireita"
        class="btn btn-success btn-sm">
        <i class="fa-solid fa-plus"></i> novo
    </button>
</div>

<?php
    $query = "SELECT * FROM banners";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
?>


<div class="card mt-3 mb-3">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between;">
            <a><?=$d->titulo?></a>

            <div>
                <button
                    excluir="<?=$d->codigo?>"
                    imagem="<?=$d->imagem?>"
                    class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-plus"></i> excluir
                </button>

                <button
                    acaoBanner="<?=$d->codigo?>"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasDireita"
                    role="button"
                    aria-controls="offcanvasDireita"
                    class="btn btn-success btn-sm">
                    <i class="fa-solid fa-plus"></i> editar
                </button>
            </div>
        </div>
    </div>
        <iframe src="<?=$localSite?>painel.php?c=banner_principal&cod=<?=$d->codigo?>" frameborder="0" style="width:100%; height:400px;"></iframe>

        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="./src/volume/banners/<?=$d->imagem?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <!-- <h5 class="card-title">Card title</h5> -->
                    <p class="card-text"><?=$d->descricao?></p>
                    <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                </div>
                </div>
            </div>
        </div>

</div>
<?php
    }
?>
<?php
//*/
?>
<script>
    $(function(){

        Carregando('none');


        $("button[novoCadastro]").click(function(){
            $.ajax({
                url:"src/noticias/form.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[edit]").click(function(){
            cod = $(this).attr("edit");
            $.ajax({
                url:"src/noticias/form.php",
                type:"POST",
                data:{
                  cod
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[delete]").click(function(){
            deletar = $(this).attr("delete");
            imagem = $(this).attr("imagem");
            $.confirm({
                content:"Deseja realmente excluir o cadastro ?",
                title:false,
                type:'red',
                buttons:{
                    'SIM':{
                        text:'<i class="fa-solid fa-trash-can"></i> Sim',
                        btnClass:'btn btn-danger',
                        action:function(){
                            $.ajax({
                                url:"src/noticias/lista.php",
                                type:"POST",
                                data:{
                                    delete:deletar,
                                    imagem
                                },
                                success:function(dados){
                                    $("#paginaHome").html(dados);
                                }
                            })
                        }
                    },
                    'NÃO':{
                        text:'<i class="fa-solid fa-ban"></i> Não',
                        btnClass:'btn btn-success'
                    }
                }
            });

        })


        $(".situacao").change(function(){

            situacao = $(this).attr("situacao");
            status = $(this).prop("checked");
            if(status === 'true'){
              opc = '1';
            }else{
              opc = '0';
            }

            $.ajax({
                url:"src/noticias/lista.php",
                type:"POST",
                data:{
                    situacao,
                    opc
                },
                success:function(dados){
                    // $("#paginaHome").html(dados);
                }
            })

        });







    })
</script>
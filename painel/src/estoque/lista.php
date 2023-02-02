<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    if($_POST['delete']){
        if($_POST['imagem']){
            unlink("../volume/estoque/".$_POST['imagem']);
        }
        $query = "delete from produtos_estoque where codigo = '{$_POST['delete']}'";
        mysqli_query($con, $query);
      }

      if($_POST['acao'] == 'estoque'){
        $query = "update produtos_estoque set estoque_atualizado = '1' where codigo = '{$_POST['cod']}'";
        mysqli_query($con, $query);
        mysqli_query($con, "update produtos set estoque = (estoque + {$_POST['quantidade']}) where codigo = '{$_POST['produto']}'");

      }

      // if($_POST['situacao']){
      //   // mysqli_query($con, "update produtos set situacao = '0'");
      //   $query = "update produtos_estoque set situacao = '{$_POST['opc']}' where codigo = '{$_POST['situacao']}'";
      //   mysqli_query($con, $query);
      //   exit();
      // }


?>
<style>

    .verde{
      color:green;
      cursor:pointer;
    }
    .vermelho{
      color:red;
      cursor:pointer;
    }
</style>



<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Registro de Estoque (<?=$_SESSION['ProdutoNome']?>)</h5>
          <div class="card-body">
            <div style="display:flex; justify-content:end">

                <button voltar class="btn btn-secondary btn-sm" style="margin-right:10px;">
                  <i class="fa-solid fa-chevron-left"></i> Voltar
                </button>

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
                  <!-- <th scope="col" style="width:50%">Produto</th> -->
                  <th scope="col" style="width:100%">Título</th>
                  <th scope="col">Data</th>
                  <th scope="col">Custo Unitário</th>
                  <th scope="col">Entrada</th>
                  <th scope="col">Comprovante</th>
                  <!-- <th scope="col">Situação</th> -->
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = "select * from produtos_estoque where tipo = 'e' and produto = '{$_SESSION['codProduto']}' order by data_cadastro desc";
                  $result = mysqli_query($con, $query);
                  while($d = mysqli_fetch_object($result)){
                ?>
                <tr>
                  <!-- <td style="white-space: nowrap;"><?=$d->produto?></td> -->
                  <td style="white-space: nowrap;"><?=$d->titulo?></td>
                  <td style="white-space: nowrap;"><?=dataBr($d->nota_data)?></td>
                  <td style="white-space: nowrap;">R$ <?=number_format($d->custo_unitario,2,',','.')?></td>
                                                   <!-- <i class="fa-solid fa-plug-circle-check"></i> -->
                                                   <!-- <i class="fa-solid fa-plug-circle-xmark"></i> -->
                  <td style="white-space: nowrap;"><i
                                                      class="fa-solid fa-plug-circle-<?=(($d->estoque_atualizado)?'check verde':'xmark vermelho')?>"
                                                      cod="<?=$d->codigo?>"
                                                      produto="<?=$d->produto?>"
                                                      quantidade="<?=$d->estoque?>"
                                                    ></i> +<?=$d->estoque?></td>
                  <td style="white-space: nowrap;"><a href='<?=$localPainel?>src/volume/estoque/<?=$d->nota?>' target='_blank'><i class="fa-solid fa-arrow-up-right-from-square"></i> Abrir</a></td>
                  <!-- <td style="white-space: nowrap;">

                  <div class="form-check form-switch">
                    <input class="form-check-input situacao" type="checkbox" <?=(($d->situacao)?'checked':false)?> situacao="<?=$d->codigo?>">
                  </div>

                  </td> -->
                  <td style="white-space: nowrap;">

                    <button
                      class="btn btn-primary btn-sm"
                      data-bs-toggle="offcanvas"
                      href="#offcanvasDireita"
                      role="button"
                      aria-controls="offcanvasDireita"
                      <?php
                      if($d->estoque_atualizado){
                      ?>
                      disabled="disabled"
                      <?php
                      }else{
                      ?>
                      edit="<?=$d->codigo?>"
                      <?php
                      }
                      ?>
                    >
                    <i class="fa-regular fa-pen-to-square"></i> Editar
                    </button>

                    <button
                      class="btn btn-danger btn-sm"
                      <?php
                      if($d->estoque_atualizado){
                      ?>
                      disabled="disabled"
                      <?php
                      }else{
                      ?>
                      delete="<?=$d->codigo?>"
                      imagem="<?=$d->imagem?>"
                      <?php
                      }
                      ?>
                      >
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

<script>
    $(function(){

        Carregando('none');

        $(".vermelho").click(function(){

          cod = $(this).attr("cod");
          produto = $(this).attr("produto");
          quantidade = $(this).attr("quantidade");
          nome = '<?=$_SESSION['ProdutoNome']?>';

          $.confirm({
            content:`Você está prestes a incluir <b>${quantidade}</b> item(ns) no estoque do produto <b>${nome}</b>.<br>Deseja realmente confirmar essa operação?`,
            title:"Inlcuir estoque de produtos",
            type:'green',
            buttons:{
              'SIM':{
                text:'Sim',
                btnClass:'btn btn-success btn-sm',
                action:function(){
                  $.ajax({
                    url:"src/estoque/lista.php",
                    type:"POST",
                    data:{
                      cod,
                      produto,
                      quantidade,
                      acao:'estoque'
                    },
                    success:function(dados){

                      $.alert({
                        content:'Atualização realizada com sucesso!',
                        title:false,
                        type:'green'
                      });
                      $("#paginaHome").html(dados);


                    }
                  })
                }
              },
              'NAO':{
                text:'Não',
                btnClass:'btn btn-danger btn-sm',
                action:function(){

                }
              },
            }
          });

        });


        $("button[novoCadastro]").click(function(){
            $.ajax({
                url:"src/estoque/form.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[edit]").click(function(){
            cod = $(this).attr("edit");
            $.ajax({
                url:"src/estoque/form.php",
                type:"POST",
                data:{
                  cod
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[estoque]").click(function(){
            produto = $(this).attr("estoque");
            $.ajax({
                url:"src/estoque/lista.php",
                type:"POST",
                data:{
                  produto
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
                                url:"src/estoque/lista.php",
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


        // $(".situacao").change(function(){

        //     situacao = $(this).attr("situacao");
        //     status = $(this).prop("checked");
        //     if(status === 'true'){
        //       opc = '1';
        //     }else{
        //       opc = '0';
        //     }

        //     $.ajax({
        //         url:"src/estoque/lista.php",
        //         type:"POST",
        //         data:{
        //             situacao,
        //             opc
        //         },
        //         success:function(dados){
        //             // $("#paginaHome").html(dados);
        //         }
        //     })

        // });


        $("button[voltar]").click(function(){
            $.ajax({
                url:"src/produtos/lista.php",
                success:function(dados){
                  $("#paginaHome").html(dados);
                }
            })
        })




    })
</script>
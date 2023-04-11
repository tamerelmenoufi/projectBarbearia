<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
    $perfil = $_SESSION['ProjectPainel']->perfil;
    if($_POST['delete']){
      $query = "delete from caixa_saida where codigo = '{$_POST['delete']}'";
      mysqli_query($con, $query);
    }

?>

<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Retiradas do Caixa</h5>
          <div class="card-body">
            <div style="display:flex; justify-content:end">
                <button
                    novoCadastro
                    class="btn btn-success"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasDireita"
                    role="button"
                    aria-controls="offcanvasDireita"
                >Novo</button>
            </div>

            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col" style="width:50%">Colaborador</th>
                  <th scope="col">Data</th>
                  <th scope="col">Valor</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = "select a.*, b.nome as nome_colaborador from caixa_saida a left join colaboradores b on a.colaborador = b.codigo order by a.data desc";
                  $result = mysqli_query($con, $query);
                  while($d = mysqli_fetch_object($result)){
                ?>
                <tr>
                  <td style="white-space: nowrap;"><?=$d->nome_colaborador?></td>
                  <td style="white-space: nowrap;"><?=$d->data?></td>
                  <td style="white-space: nowrap;"><?=number_format($d->valor,2,'.',false)?></td>
                  <td style="white-space: nowrap;">

                    <button
                      class="btn btn-primary"
                      edit="<?=$d->codigo?>"
                      data-bs-toggle="offcanvas"
                      href="#offcanvasDireita"
                      role="button"
                      aria-controls="offcanvasDireita"
                    >
                      Editar
                    </button>

                    <?php
                    if($perfil == 'a'){
                    ?>
                    <button delete="<?=$d->codigo?>" class="btn btn-danger" >
                      Excluir
                    </button>
                    <?php
                    }
                    ?>

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
        $("button[novoCadastro]").click(function(){
            $.ajax({
                url:"src/caixa_saida/form.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[edit]").click(function(){
            cod = $(this).attr("edit");
            $.ajax({
                url:"src/caixa_saida/form.php",
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
            $.confirm({
                content:"Deseja realmente excluir o cadastro ?",
                title:false,
                type:'red',
                buttons:{
                    'SIM':function(){
                        $.ajax({
                            url:"src/caixa_saida/index.php",
                            type:"POST",
                            data:{
                                delete:deletar
                            },
                            success:function(dados){
                              // $.alert(dados);
                              $("#paginaHome").html(dados);
                            }
                        })
                    },
                    'NÃO':function(){

                    }
                }
            });

        })



    })
</script>
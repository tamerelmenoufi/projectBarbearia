<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

        if($_POST['acao'] == 'perfil'){

            $dados = [];

            // mysqli_query($con, "delete from colaboradores_produtos where colaborador = '{$_POST['colaborador']}'");

            foreach($_POST['produto'] as $i => $val){

                $chave = md5($_POST['colaborador'].$val);
                $dados[] = "( '{$chave}', '{$_POST['colaborador']}', '{$val}', '{$_POST['tipo'][$i]}', '{$_POST['valor'][$i]}', '{$_POST['situacao'][$i]}' )";

            }
            if($dados){
                $query = "REPLACE INTO colaboradores_produtos (chave, colaborador, produto, tipo_comissao, valor, situacao) VALUES ".@implode(", ", $dados);
                mysqli_query($con, $query);
            }

            exit();

        }


        $query = "select * from colaboradores_produtos where colaborador = '{$_POST['colaborador']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        print_r($d);



?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>">Perfil de Serviços</h4>
    <div id="form-<?= $md5 ?>">
        <h5><?=$_POST['colaborador']?></h5>
        <hr>
        <div class="row">
            <div class="col">
            <?php
            $categoria = false;
            $query = "select a.*, b.categoria as nome_categoria from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' order by b.categoria asc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
                if($categoria != $d->nome_categoria){
                    $categoria = $d->nome_categoria;
            ?>
            <h6><?=$categoria?></h6>
            <?php
                }
            ?>
            <div class="input-group mb-3">
                <span class="input-group-text" style="width:60%">
                    <div class="form-check form-switch">
                        <input class="form-check-input perfil" type="checkbox" <?=(($d->situacao)?'checked':false)?> produto="<?=$d->codigo?>">
                    </div>
                    <?=$d->produto?>
                </span>
                <select tipo<?=$d->codigo?> class="form-control" >
                    <option value="p">%</option>
                    <option value="v">$</option>
                </select>
                <input  valor<?=$d->codigo?> value="" type="number" class="form-control">
            </div>
            <?php
            }
            ?>

            <button salvar_perfil class="btn btn-primary btn-block mt-3 mb-3"><i class="fa-regular fa-floppy-disk"></i> Salvar Perfil</button>

            </div>
        </div>

    </div>

    <script>
        $(function(){
            Carregando('none');

            $('button[salvar_perfil]').click(function (e) {

                colaborador = '<?=$_POST['cod']?>';
                produto = [];
                tipo = [];
                valor = [];
                situacao = [];
                $("input.perfil").each(function(){
                    // if($(this).prop("checked") == true){
                        cod = $(this).attr("produto");
                        produto.push($(this).attr("produto"));
                        tipo.push($(`select[tipo${cod}]`).val());
                        valor.push($(`input[valor${cod}]`).val());
                        situacao.push((($(this).prop("checked") == true)?'1':'0'));

                    // }
                })

                Carregando();

                $.ajax({
                    url:"src/colaboradores/servicos.php",
                    type:"POST",
                    data:{
                        colaborador,
                        produto,
                        tipo,
                        valor,
                        situacao,
                        acao:'perfil'
                    },
                    success:function(dados){
                        // $.alert(dados)
                        Carregando('none');
                    },
                    error:function(erro){

                    }
                });

            });

        })
    </script>
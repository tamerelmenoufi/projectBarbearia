<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");


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
    <form id="form-<?= $md5 ?>">
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
                <span class="input-group-text" id="basic-addon1" style="width:60%">
                    <div class="form-check form-switch">
                        <input class="form-check-input situacao" type="checkbox" <?=(($d->codigo == 1)?'disabled':false)?> <?=(($d->situacao)?'checked':false)?> usuario="<?=$d->codigo?>">
                    </div>
                    <?=$d->produto?>
                </span>
                <select class="form-control" >
                    <option value="p">%</option>
                    <option value="v">$</option>
                </select>
                <input type="number" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <?php
            }
            ?>

            <button class="btn btn-primary btn-block mt-3 mb-3"><i class="fa-regular fa-floppy-disk"></i> Salvar Perfil</button>

            </div>
        </div>

    </form>

    <script>
        $(function(){
            Carregando('none');

            $("#cpf").mask("999.999.999-99");
            $("#telefone").mask("(99) 99999-9999");

            $('#form-<?=$md5?>').submit(function (e) {

                e.preventDefault();

                var codigo = $('#codigo').val();
                var campos = $(this).serializeArray();

                if (codigo) {
                    campos.push({name: 'codigo', value: codigo})
                }

                campos.push({name: 'acao', value: 'salvar'})

                Carregando();

                $.ajax({
                    url:"src/colaboradores/form.php",
                    type:"POST",
                    typeData:"JSON",
                    mimeType: 'multipart/form-data',
                    data: campos,
                    success:function(dados){
                        // if(dados.status){
                            $.ajax({
                                url:"src/colaboradores/index.php",
                                type:"POST",
                                success:function(dados){
                                    $("#paginaHome").html(dados);
                                    let myOffCanvas = document.getElementById('offcanvasDireita');
                                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                                    openedCanvas.hide();
                                }
                            });
                        // }
                    },
                    error:function(erro){

                        // $.alert('Ocorreu um erro!' + erro.toString());
                        //dados de teste
                    }
                });

            });

        })
    </script>
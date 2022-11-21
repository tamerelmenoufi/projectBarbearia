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
        <div class="row">
            <div class="col">
            <?php
            $categoria = false;
            $query = "select a.*, b.categoria as nome_categoria from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.codigo = '{$_POST['cod']}' order by b.categoria asc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
                if($categoria != $d->nome_categoria){
                    $categoria = $d->nome_categoria;
            ?>
            <h6>C: <?=$categoria?></h6>
            <?php
                }
            ?>
            <p>P: <?=$d->produto?></p>
            <?php
            }
            ?>
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
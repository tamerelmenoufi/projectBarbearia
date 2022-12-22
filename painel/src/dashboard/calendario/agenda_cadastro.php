<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
    $data_agenda = $_SESSION['agenda_dia'].' '.$_POST['data'];

    function filtroServicoColaborador($c){
        global $con;
        $query = "select
                        a.*,
                        b.produto as produto_nome,
                        c.categoria as categoria_nome
                    from
                        colaboradores_produtos a
                        left join produtos b on a.produto = b.codigo
                        left join produtos_categorias c on b.categoria = c.codigo
                    where a.colaborador = '{$c}' and b.tipo = 's' and a.situacao = '1' order by c.categoria, b.produto";

        $result = mysqli_query($con, $query);
        $grupo = false;
        while($d = mysqli_fetch_object($result)){

            if($grupo != $d->categoria_nome){
                if($grupo != false){
                    echo "</optgroup>";
                }
                echo "<optgroup label='{$d->categoria_nome}'>";
            }
            echo "<option value='{$d->produto}'>{$d->produto_nome}</option>";
            $grupo = $d->categoria_nome;
        }
        echo "</optgroup>";
    }

    if($_POST['acao'] == 'filto_servicos'){
        filtroServicoColaborador($_POST['colaborador']);
        exit();
    }


?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>"><?=dataBr($data_agenda)?></h4>

<div class="row mb-2">
    <div class="col-12">
        <label for="cliente" class="form-label">Cliente *</label>
        <select
                name="cliente"
                id="cliente"
                data-live-search="true"
                data-none-selected-text="Selecione"
                class="form-control">
            <option value="">Selecione</option>
        <?php
            $query = "select * from clientes order by nome";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){

        ?>
            <option value="<?=$d->codigo?>"><?=$d->nome?></option>
        <?php
            }
        ?>
        </select>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <label for="colaborador" class="form-label">Colaborador (Atendente) *<br><small style="color:#a1a1a1; font-size:10px;">Colaboradores desativados estão com agenda indisponível.</small></label>
        <select
                name="colaborador"
                id="colaborador"
                data-live-search="true"
                data-none-selected-text="Selecione"
                class="form-control">
            <option value="">Selecione</option>
                <?php
            $query = "select a.*, (select count(*) from agenda where colaborador = a.codigo and data_agenda = '{$data_agenda}') as agenda from colaboradores a where a.situacao = '1' order by a.nome";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
        ?>
            <option value="<?=(($d->agenda > 0)?false:$d->codigo)?>" <?=(($d->agenda > 0)?'disabled':false)?>><?=$d->nome?></option>
        <?php
            }
        ?>
        </select>
    </div>
</div>


<div class="row mb-2">
    <div class="col-12">
        <label for="servico" class="form-label">Serviço *</label>
        <select
                name="servico"
                id="servico"
                data-live-search="true"
                data-none-selected-text="Selecione"
                class="selectpicker form-control"
                multiple
                data-actions-box="true"
                ></select>
    </div>
</div>


<div class="row mb-2">
    <div class="col-12">
        <label for="exampleInputEmail1" class="form-label">Observações </label>
        <textarea name="observacao" id="observacao" class="form-control" rows="5"></textarea>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <button class="btn btn-primary cadastrarAgenda"><i class="fa-solid fa-calendar-plus"></i> Cadastrar agenda</button>
    </div>
</div>

<script>
    $(function(){

        $("#cliente").selectpicker();
        $("#colaborador").selectpicker();
        $("#servico").selectpicker();

        $('#colaborador').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            colaborador = $(this).val();
            $("#servico").selectpicker('destroy');
            $.ajax({
                url:"src/dashboard/calendario/agenda_cadastro.php",
                type:"POST",
                data:{
                    colaborador,
                    acao:'filto_servicos'
                },
                success:function(dados){
                    $("#servico").html(dados);
                    $("#servico").selectpicker('render');
                }
            });
        });


        $(".cadastrarAgenda").click(function(){

            cliente = $("#cliente").val();
            colaborador = $("#colaborador").val();
            servico = $("#servico").val();
            observacao = $("#observacao").val();
            data_agenda = '<?=$data_agenda?>';

            // console.log(servico);
            // return false;

            if(!cliente || !colaborador || !servico){
                $.alert({
                    content:'Favor preencha os dados obrigatórios (*) no formulário!',
                    type:'red',
                    title:"ALERTA"
                });
                return false;
            }

            Carregando();
            $.ajax({
                url:"src/dashboard/calendario/agenda_dia.php",
                type:"POST",
                data:{
                    cliente,
                    colaborador,
                    servico,
                    observacao,
                    data_agenda,
                    acao:'nova_agenda'
                },
                success:function(dados){
                    $("div[agendaDia]").html(dados);
                    let myOffCanvas = document.getElementById('offcanvasDireita');
                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    openedCanvas.hide();
                }
            });
        });


    })
</script>
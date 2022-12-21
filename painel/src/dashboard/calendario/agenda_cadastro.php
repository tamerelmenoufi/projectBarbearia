<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $data_agenda = $_SESSION['agenda_dia'].' '.$_POST['data'];
?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>"><?=$_SESSION['agenda_dia']?> <?=$data_agenda?></h4>

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
        <label for="colaborador" class="form-label">Colaborador (Atendente) *</label>
        <select
                name="colaborador"
                id="colaborador"
                data-live-search="true"
                data-none-selected-text="Selecione"
                class="form-control">
            <option value="">Selecione</option>
                <?php
            $query = "select * from colaboradores where situacao = '1' order by nome";
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
        <label for="servico" class="form-label">Serviço *</label>
        <select
                name="servico"
                id="servico"
                data-live-search="true"
                data-none-selected-text="Selecione"
                class="form-control">
            <option value="">Selecione</option>
                <?php
            $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.tipo = 's' and a.situacao = '1' and b.situacao = '1' order by b.categoria, a.produto";
            $result = mysqli_query($con, $query);
            $grupo = false;
            while($d = mysqli_fetch_object($result)){

            if($grupo != $d->categoria_nome){
        ?>
        <optgroup label="<?=$d->categoria_nome?>">
        <?php
                }
        ?>
            <option value="<?=$d->codigo?>"><?=$d->produto?></option>
        <?php
            if($grupo != $d->categoria_nome){
        ?>
        </optgroup>
        <?php
            }
            $grupo = $d->categoria_nome;
            }
        ?>
        </select>
    </div>
</div>


<div class="row mb-2">
    <div class="col-12">
        <label for="exampleInputEmail1" class="form-label">Observações </label>
        <textarea name="observacao" id="observacao" class="form-control" cols="30" rows="10"></textarea>
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

        $("#cadastrarAgenda").click(function(){

            cliente = $("#cliente").val();
            colaborador = $("#colaborador").val();
            servico = $("#servico").val();
            observacao = $("#observacao").val();
            data_agenda = '<?=$data_agenda?>';

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
                }
            });
        });


    })
</script>
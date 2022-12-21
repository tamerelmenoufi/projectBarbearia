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
<h4 class="Titulo<?=$md5?>"><?=$_SESSION['agenda_dia']?> <?=$_POST['data']?></h4>

<div class="row mb-2">
    <div class="col-12">
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
        <textarea name="observacao" id="observacao" class="form-control" cols="30" rows="10"></textarea>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <button class="btn btn-primary">Cadastrar agenda</button>
    </div>
</div>

<script>
    $(function(){

        $("#cliente").selectpicker();
        $("#colaborador").selectpicker();


    })
</script>
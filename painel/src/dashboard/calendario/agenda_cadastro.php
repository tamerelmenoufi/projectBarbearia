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

<div class="row">
    <div class="col-12">
        <select name="cliente" id="cliente">
            <option value="1">Nome do cliente</option>
            <option value="1">Nome do cliente</option>
            <option value="1">Nome do cliente</option>
            <option value="1">Nome do cliente</option>
            <option value="1">Nome do cliente</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <select name="colaborador" id="colaborador">
            <option value="1">Nome do colaborador</option>
            <option value="1">Nome do colaborador</option>
            <option value="1">Nome do colaborador</option>
            <option value="1">Nome do colaborador</option>
            <option value="1">Nome do colaborador</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <textarea name="observacao" id="observacao" class="form-control" cols="30" rows="10"></textarea>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <button class="btn btn-primary">Cadastrar agenda</button>
    </div>
</div>
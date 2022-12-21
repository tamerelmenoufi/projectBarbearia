<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .agendamento{
        margin-left:20px;
        padding:3px;
        border-radius:5px;
        background-color:rgb(125,11,234, 0.9);
        color:#fff;
        font-size:7px;
        white-space:nowrap;
        cursor: pointer;
    }
    .nova_agenda{
        cursor:pointer;
    }
</style>

<div class="p-1" style="font-size:12px;">
    <div class="row mb-3">
        <div class="col text-start"><h6>Agenda do dia</h6></div>
        <div class="col text-end"><input type="date" id="dataAgenda" class="form-control form-control-sm" /></div>
    </div>

    <ul class="list-group">
    <?php
    for($i=0;$i<24;$i++){
        $j = [0,15,30,45];
        foreach($j as $ind => $h){
            $hora = str_pad($i , 2 , '0' , STR_PAD_LEFT).":".str_pad($h , 2 , '0' , STR_PAD_LEFT);
    ?>
    <li class="list-group-item">
        <span class="nova_agenda"><i class="fa-solid fa-calendar-plus"></i> <?=$hora?></span>
        <div agendamento style="position:absolute; left:70px; right:10px; height:auto; top:4px;" >
            <?php
            for($w = 0; $w < 20; $w++){
            ?>
            <span class="agendamento">José Ribamar<br> <i>Eduardo Fernandes</i> </span>
            <?php
            }
            ?>
        </div>
    </li>
    <?php
        }
    }
    ?>
</div>

<script>
    $(function(){

        $('div[agendamento]').flickity({
            // options
            cellAlign: 'left',
            contain: true,
            freeScroll: true,
            prevNextButtons: false,
            pageDots: false
        });


        $(".agendamento").click(function(){

            $.alert('Visualização da agenda!');

        });

        $(".nova_agenda").click(function(){
            $.alert('Novo cadastro!');
        })

    })
</script>
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);


    $conf = mysqli_fetch_object(mysqli_query($con, "select * from configuracoes where codigo = '1'"));

    if($_POST['acao'] == 'cancelar_agenda'){

        mysqli_query($con, "delete from agenda where codigo = '{$_POST['codigo']}'");

    }

    if($_POST['agenda_dia']){
        $_SESSION['agenda_dia'] = $_POST['agenda_dia'];
    }


    $_SESSION['agenda_dia'] = (($_SESSION['agenda_dia'])?:date("Y-m-d"));

    if($_POST['acao'] == 'nova_agenda'){

        // $servicos = json_encode($_POST['servico']);

        $query = "insert into agenda set
                                        tipo_cadastro = 'u',
                                        usuario = '{$_SESSION['ProjectPainel']->codigo}',
                                        colaborador = '{$_POST['colaborador']}',
                                        cliente = '{$_POST['cliente']}',
                                        servico = '{$_POST['servico']}',
                                        observacao = '{$_POST['observacao']}',
                                        data_agenda = '{$_POST['data_agenda']}',
                                        data_cadastro = NOW(),
                                        situacao = 'n'";
        mysqli_query($con, $query);

    }


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
    div[agendamento]{

    }
    .nova_agenda{
        cursor:pointer;
    }
</style>

<div class="p-1" style="font-size:12px;">
    <div class="mb-3">
        <div class="row" style="margin:0; padding:0;">
            <div class="col text-start"><h6>Agenda do dia <?=$hoje?></h6></div>
            <div class="col text-end">
                <!-- <input type="date" id="dataAgenda" class="form-control form-control-sm" value="<?=$_SESSION['agenda_dia']?>" />
                <button class="btn btn-primary">Buscar</button>
                <button class="btn btn-success">Agendar</button> -->

                <div class="input-group">
                    <input type="date" id="dataAgenda" class="form-control form-control-sm" value="<?=$_SESSION['agenda_dia']?>" />
                    <button class="btn btn-primary buscarDataAgenda">Buscar</button>
                    <!-- <label class="input-group-text">Agenda do dia <?=$hoje?></label> -->
                    <button
                            class="btn btn-success nova_agenda"
                            data-bs-toggle="offcanvas"
                            href="#offcanvasDireita"
                            role="button"
                            aria-controls="offcanvasDireita"
                    >Agendar</button>
                </div>


            </div>
        </div>
    </div>

    <ul class="list-group">
    <?php
    for($i=9;$i<=20;$i++){
        $j = [0,5,10,15,20,25,30,35,40,45,50,55];
        foreach($j as $ind => $h){
            $hora = str_pad($i , 2 , '0' , STR_PAD_LEFT).":".str_pad($h , 2 , '0' , STR_PAD_LEFT);
    ?>
    <li class="list-group-item">
        <span><i class="fa-solid fa-calendar-plus"></i> <?=$hora?></span>
        <div agendamento style="position:absolute; left:70px; right:10px; height:auto; top:4px;" >
            <?php
            $query = "select
                            a.*,
                            b.nome as cliente_nome,
                            c.nome as colaborador_nome
                        from agenda a
                            left join clientes b on a.cliente = b.codigo
                            left join colaboradores c on a.colaborador = c.codigo
                        where data_agenda = '{$_SESSION['agenda_dia']} {$hora}' order by a.data_cadastro asc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <span
                data-bs-toggle="offcanvas"
                href="#offcanvasDireita"
                role="button"
                aria-controls="offcanvasDireita"
                class="agendamento"
                hora="<?=$hora?>"
                codigo="<?=$d->codigo?>"><?=$d->cliente_nome?><br> <i><?=$d->colaborador_nome?></i> </span>
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

        Carregando('none');

        $('div[agendamento]').flickity({
            // options
            cellAlign: 'left',
            contain: true,
            freeScroll: true,
            prevNextButtons: false,
            pageDots: false
        });


        $(".agendamento").click(function(){
            codigo = $(this).attr("codigo");
            hora = $(this).attr("hora");
            $.ajax({
                url:"src/dashboard/calendario/agenda_consulta.php",
                type:"POST",
                data:{
                    codigo,
                    hora,
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });

        $(".nova_agenda").click(function(){
            // data = $(this).attr("data");
            $.ajax({
                url:"src/dashboard/calendario/agenda_cadastro.php",
                // type:"POST",
                // data:{
                //     data,
                // },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })

        $(".buscarDataAgenda").click(function(){
            agenda_dia = $("#dataAgenda").val();
            $("div[agendaDia]").css("opacity",0.2);
            $.ajax({
                url:"src/dashboard/calendario/agenda_dia.php",
                type:"POST",
                data:{
                    agenda_dia
                },
                success:function(dados){
                    $("div[agendaDia]").html(dados);
                    $("div[agendaDia]").css("opacity",1);
                }
            });
        })

    })
</script>
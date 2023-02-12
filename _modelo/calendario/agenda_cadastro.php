<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $conf = mysqli_fetch_object(mysqli_query($con, "select * from configuracoes where codigo = '1'"));

    $data_agenda = $_SESSION['agenda_dia'].' '.$_POST['data'];


    $hoje = $abrevSem[date("D")];

    function filtroServicoColaborador($c){
        global $con;
        global $localPainel;
        global $abrevSem;
        global $_SESSION;

        $c = implode(", ",$c);

        ////////////////////DEFINIR HORARIOS//////////////////////////////////////
        $PeriodoLoja = mysqli_fetch_object(mysqli_query($con, "select * from configuracoes where codigo = '1'"));

        $dia_serv = json_decode($PeriodoLoja->dias_horas_atendimento);

        if($_POST['ano'] and $_POST['mes']){
            $ano = $_POST['ano'];
            $mes = $_POST['mes'];
            $dia = (($_POST['dia'])?:date("d"));
        }else{
            $ano = date(Y);
            $mes = date(m);
            $dia = date(d);
        }


        $prox_a = date("Y", mktime(0,0,0,$mes+1,$dia, $ano));
        $prox_m = date("m", mktime(0,0,0,$mes+1,$dia, $ano));
        $prox_d = date("d", mktime(0,0,0,$mes+1,$dia, $ano));

        $ante_a = date("Y", mktime(0,0,0,$mes-1,$dia, $ano));
        $ante_m = date("m", mktime(0,0,0,$mes-1,$dia, $ano));
        $ante_d = date("d", mktime(0,0,0,$mes-1,$dia, $ano));



        ////////////////////DEFINIR HORARIOS//////////////////////////////////////

        $query = "select
                        a.*,
                        b.produto as produto_nome,
                        c.categoria as categoria_nome,
                        d.nome as colaborador_nome,
                        d.foto
                    from
                        colaboradores_produtos a
                        left join produtos b on a.produto = b.codigo
                        left join produtos_categorias c on b.categoria = c.codigo
                        left join colaboradores d on a.colaborador = d.codigo
                    where a.produto in ({$c}) and b.tipo = 's' and a.situacao = '1' order by b.produto, d.nome";

        $result = mysqli_query($con, $query);
        $grupo = false;
        echo "<option value=''>Selecione</option>";
        while($d = mysqli_fetch_object($result)){

            $servico = $d->produto;
            $colaborador = $d->colaborador;


            $hj = $abrevSem[date("D", mktime(0,0,0,$mes,$dia,$ano))];
            if($dia_serv->$hj){
                list($hi, $hf) = explode("-",$dia_serv->$hj);
                $inter_ini = strtotime(date("Y-m-d {$hi}:00", mktime(0,0,0,$mes,$dia,$ano)));
                $inter_fim = strtotime(date("Y-m-d {$hf}:00", mktime(0,0,0,$mes,$dia,$ano)));

                $s = mysqli_fetch_object(mysqli_query($con, "select * from produtos where codigo = '{$d->produto}'"));

                $q = "select *, DATE_FORMAT(`data_agenda`,'%H') as h, DATE_FORMAT(`data_agenda`,'%i') as i from agenda where data_agenda like '%{$ano}-{$mes}-{$dia}%' and colaborador = '{$d->colaborador}' and servico = {$d->produto}";
                $r = mysqli_query($con, $q);
                $ag = [];
                while($h = mysqli_fetch_object($r)){
                    $ag[] = "{$h->h}:{$h->i}";
                }

            }


            if($grupo != $d->produto_nome){
                echo "<h4>$d->produto_nome</h4>";
                echo "<input
                            type='hidden'
                            class='opcAgenda'
                            colaborador=''
                            ano=''
                            mes=''
                            dia=''
                            horario=''
                            servico='{$d->produto}' />";
            }
        ?>
<div class="card mb-3">
  <div class="row g-0">
    <div class="col-md-3">
      <img src="<?=$localPainel?>src/volume/colaboradores/<?=$d->foto?>" class="img-fluid rounded-start" >
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">
            <b><?=$d->produto_nome?></b>
            <i>com:</i><br>
            <?=$d->colaborador_nome?><br>
            <span class="agenda<?=$d->produto?>" id="agenda<?=$d->produto.$d->colaborador?>"></span>
        </h5>
        <p class="card-text">
        <div class="row">
        <div class="col-6">
        <?=date("d/m/Y",$inter_ini)?>
        </div>
        <div class="col-6">
        <select
            name="<?="opcHoras_{$d->colaborador}{$d->produto}"?>"
            data-live-search="true"
            data-none-selected-text="Selecione"
            class="selectpicker form-control opcHoras <?="opcHoras{$d->colaborador}{$d->produto}"?>"
            data-actions-box="true"
        >
            <option value="" >Horarios Disponiveis</option>
        <?php


            // echo "<p>Colab.: {$_POST['colaborador']} - Serv.: {$_POST['servico']}</p>";
            if($dia_serv->$hj){

                $ano=date("Y",$inter_ini);
                $mes=date("m",$inter_ini);
                $dia=date("d",$inter_ini);

            for($i = $inter_ini; $i <= $inter_fim; $i = (($i + 60*$s->tempo))){

                if(!in_array(date("H:i",$i),$ag)){

        ?>

                <!-- <input
                    type="radio"
                    class="btn-check mb-1 mt-1 opcHoras"
                    name="<?="opcHoras_{$d->colaborador}{$d->produto}"?>"
                    colaborador="<?=$d->colaborador?>"
                    servico="<?=$d->produto?>"
                    id="option<?="{$d->colaborador}{$d->produto}"?>"
                    autocomplete="off"
                    ano="<?=date("Y",$i)?>"
                    mes="<?=date("m",$i)?>"
                    dia="<?=date("d",$i)?>"
                    value="<?=date("H:i",$i)?>"
                >
                <label
                    class="btn btn-outline-primary mb-1 mt-1"
                    for="option<?=$i?>"

                ><?=date("H:i",$i)?></label> -->
                <option value="<?=date("H:i",$i)?>" ><?=date("H:i",$i)?></option>
                <!-- <button
                        class="btn btn-outline-primary btn-sm mb-1 mt-1 opcHoras"
                        name="<?="opcHoras_{$d->colaborador}{$d->produto}"?>"
                        colaborador="<?=$d->colaborador?>"
                        servico="<?=$d->produto?>"
                        id="option<?="{$d->colaborador}{$d->produto}"?>"
                        ano="<?=date("Y",$i)?>"
                        mes="<?=date("m",$i)?>"
                        dia="<?=date("d",$i)?>"
                        value="<?=date("H:i",$i)?>"

                >
                    <?=date("H:i",$i)?>
                </button> -->
                <!-- echo "<p>".date("d/m/Y H:i",$i)." - ".$s->tempo."</p>"; -->
        <?php
                }
            }
            }

            // $inter_ini = strtotime(date("Y-m-d 10:00:00"));
            // $inter_fim = strtotime(date("Y-m-d 10:01:00"));
            // echo "<p>{$inter_ini} até {$inter_fim}</p>";
            // echo ($inter_fim - $inter_ini);
        ?>
            </select>
            </div>
            </div>
        </p>
      </div>
    </div>
  </div>
</div>
        <?php
            $grupo = $d->produto_nome;
        }
        ?>

<script>
    $(function(){

        $(".opcHoras").selectpicker();

        $(".opcHoras").change(function() {

            hora = $(this).val();

            ano = "<?=$ano?>";
            mes = "<?=$mes?>";
            dia = "<?=$dia?>";
            servico = "<?=$servico?>";
            colaborador = "<?=$colaborador?>";

            if(hora && ano && mes && dia && servico && colaborador){

            agenda = `${ano}-${mes}-${dia} ${hora}`;
            rotulo = `${dia}/${mes}/${ano} ${hora}`;
            // console.log(`#agenda${servico}${colaborador}`)

            // obj = $(`.opcAgenda`);
            // obj.attr("ano",'');
            // obj.attr("mes",'');
            // obj.attr("dia",'');
            // obj.attr("colaborador",'');
            // obj.attr("hora",'');

            $(`.#agenda${servico}${colaborador}`).val('');
            $(this).val(hora);
            $(".opcHoras").selectpicker();

            obj = $(`.opcAgenda[servico='${servico}']`);
            obj.attr("ano",ano);
            obj.attr("mes",mes);
            obj.attr("dia",dia);
            obj.attr("colaborador",colaborador);
            obj.attr("hora",hora);



            $(`.agenda${servico}`).text('');
            $(`#agenda${servico}${colaborador}`).text(rotulo);

            $(".cadastrarAgenda").attr("agenda", agenda);
            $(".cadastrarAgenda span").text(rotulo);
            $(".cadastrarAgenda").removeAttr("disabled");

            // $("span[Titulo]").text(rotulo);
            }

        });
    })
</script>


<?php

    }

    if($_POST['acao'] == 'filto_servicos'){
        filtroServicoColaborador($_POST['servico']);
        exit();
    }


    // $agora = mktime(date("H"), date("m"), date("s"), date("m"), date("d"), date("Y"));
    // $dt = explode("-",$_SESSION['agenda_dia']);
    // $hs = explode(":",$_POST['data']);
    // $agenda = mktime($hs[0], $hs[1], date("s"), $dt[1], $dt[2], $dt[0]);

    // $blq = false;
    // if($agenda <= $agora){
    //     $blq = true;
    // }

?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
        width:calc(100% - 80px);
    }
    .dropdown-item.active, .dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: #9f9f9f;
}

.offcanvas-body {
    flex-grow: 1;
    padding: 1rem 1rem;
    overflow-y: auto;
    background: #e5e5e5;
}
.btn-primary:hover {
    color: #fff;
    background-color: #291a0e;
    border-color: #291a0e;
}

.btn-check:focus+.btn-primary, .btn-primary:focus {
    color: #fff;
    background-color: #291a0e;
    border-color: #291a0e;
    box-shadow: 0 0 0 0.25rem rgb(76 62 51);
}


.btn-check:active+.btn-primary, .btn-check:checked+.btn-primary, .btn-primary.active, .btn-primary:active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #664830;
    border-color: #664830;
}
.btn-primary.disabled, .btn-primary:disabled {
    color: #fff;
    background-color: #664830;
    border-color: #664830;
}

.btn-primary {
    color: #fff;
    background-color: #664830;
    border-color: #664830;
}

</style>
<h4 class="Titulo<?=$md5?> d-flex justify-content-between" >
    <div class="col text-start">
        <d style="color:#918d87">Agenda <span Titulo></span></d>
    </div>
    <div class="col text-end">
        <button class="btn btn-warning btn-sm sair"><i class="fa fa-close"></i> Sair</button>
    </div>
</h4>

<?php
/*
    if($blq){
?>
<!-- <div class="row">
    <div class="col-12">
        <div style="width:100%; height:300px; color:#a1a1a1; opacity:0.5; padding-top:80px; text-align:center;">
            <h1><i class="fa-solid fa-ban"></i><br>Data não autorizada</h1>
        </div>
    </div>
</div> -->
<?php
 }else{
//*/
?>
<div class="row mb-2">
    <div class="col-12">
        <label for="cliente" class="form-label"><i class="fa-regular fa-user"></i> Cliente </label>
        <?php
            $query = "select * from clientes where codigo = '{$_SESSION['cliente']}'";
            $result = mysqli_query($con, $query);
            $d = mysqli_fetch_object($result);
        ?>
        <div class="form-control"><?=$d->nome?></div>
        <input type="hidden" id="cliente" name="cliente" value="<?=$d->codigo?>" />
    </div>
</div>


<div class="row mb-2">
    <div class="col-12">
        <label for="servico" class="form-label"> <i class="fa fa-scissors"></i> Serviço</label>
        <select
            name="servico"
            id="servico"
            data-live-search="true"
            data-none-selected-text="Selecione"
            class="selectpicker form-control"
            data-actions-box="true"
            multiple
        >
        <?php
        $q = "select * from produtos where tipo = 's' and situacao = '1' order by produto";
        $r = mysqli_query($con, $q);
        while($s = mysqli_fetch_object($r)){
        ?>
            <option value="<?=$s->codigo?>" <?=(($_SESSION['servico'] == $s->codigo)?'selected':false)?>><?=$s->produto?></option>
        <?php
        }
        ?>

        </select>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12 horarios">
            <!--<b style="color:#fff">Horarios:</b>-->
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <!-- <label for="colaborador" class="form-label"> <i class="fa fa-people-group"></i> Colaborador (Atendente) <br><small style="color:#a1a1a1; font-size:13px;">Colaboradores desativados estão com agenda indisponível.</small></label> -->
        <div id="colaborador"></div>
        <!-- <select
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
        </select> -->
    </div>
</div>





<div class="row mb-2">
    <div class="col-12">
        <label for="observacao" class="form-label">Observações </label>
        <textarea name="observacao" id="observacao" class="form-control" rows="5"></textarea>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12">
        <button class="btn btn-primary cadastrarAgenda" agenda="" disabled><i class="fa-solid fa-calendar-plus"></i> Agenda para <span></span></button>
    </div>
</div>
<?php
// }
?>
<script>
    $(function(){

        // $("#cliente").selectpicker();
        // $("#colaborador").selectpicker();
        $("#servico").selectpicker();

        // $("#colaborador").change(function(){
        //     colaborador = $("#colaborador").val();
        //     servico = $(this).val();

        //     $(".cadastrarAgenda").attr("agenda",'');
        //     $(".cadastrarAgenda span").text('');
        //     $("span[Titulo]").text('');
        //     $(".cadastrarAgenda").attr("disabled","disabled");
        //     $(".horarios").html('');

        //     if(colaborador && servico){
        //         $.ajax({
        //             type:"POST",
        //             data:{
        //                 colaborador,
        //                 servico,
        //             },
        //             url:"calendario/horarios.php",
        //             success:function(dados){
        //                 $(".horarios").html(dados);
        //             }
        //         });
        //     }
        // });


        $('#servico').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        // $('#servico').on('change', function (e, clickedIndex, isSelected, previousValue) {
            servico = $(this).val();

            // $("#colaborador").selectpicker('destroy');
            $(".cadastrarAgenda").attr("agenda",'');
            $(".cadastrarAgenda span").text('');
            $("span[Titulo]").text('');
            $(".cadastrarAgenda").attr("disabled","disabled");
            $(".horarios").html('');

            if(servico.length){
                $.ajax({
                    url:"calendario/agenda_cadastro.php",
                    type:"POST",
                    data:{
                        servico,
                        acao:'filto_servicos'
                    },
                    success:function(dados){
                        $("#colaborador").html(dados);
                        // $("#colaborador").selectpicker('render');

                        colaborador = $("#colaborador").val();
                        console.log(`Servicos ${servico}`)
                        console.log(`colaborador ${colaborador}`)
                        // if(colaborador && servico){
                            $.ajax({
                                type:"POST",
                                data:{
                                    colaborador,
                                    servico,
                                },
                                url:"calendario/horarios.php",
                                success:function(dados){
                                    $(".horarios").html(dados);
                                }
                            });
                        // }


                    }
                });
            }else{
                        $("#colaborador").html('<option value="">Selecionar</value>');
                        $("#colaborador").selectpicker('render');
            }
        });


        $(".cadastrarAgenda").click(function(){

            // cliente = $("#cliente").val();



            // colaborador = $("#colaborador").val();
            // servico = $("#servico").val();
            // observacao = $("#observacao").val();
            // data_agenda = $(this).attr("agenda");

            data = [];
            error = false;
            $(".opcAgenda").each(function(){
                ano = $(this).attr('ano');
                mes = $(this).attr('mes');
                dia = $(this).attr('dia');
                hora = $(this).attr('hora');
                colaborador = $(this).attr('colaborador');
                servico = $(this).attr('servico');
                cliente = $("#cliente").val();
                observacao = $("#observacao").val();

                if(
                    ano &&
                    mes &&
                    dia &&
                    hora &&
                    colaborador &&
                    servico &&
                    cliente
                ){
                    data.push({
                        ano,
                        mes,
                        dia,
                        hora,
                        colaborador,
                        servico,
                        cliente
                    })
                }else{
                    error = true;
                }

            })

            // console.log(data);

            // return false;

            if(error){
                $.alert({
                    content:'Favor preencha os dados obrigatórios (*) no formulário!',
                    type:'red',
                    title:"ALERTA"
                });
                return false;
            }

            $.ajax({
                url:"calendario/agenda_dia.php",
                type:"POST",
                data:{
                    data,
                    observacao,
                    acao:'nova_agenda'
                },
                success:function(dados){
                    // $.alert(dados)
                    // return;
                    $.alert('Seu Agendamento foi confirmada!')
                    let myOffCanvas = document.getElementById('offcanvasRight');
                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    openedCanvas.hide();
                    $(".LateralDireita").html('');
                }
            });
        });



        $(".sair").click(function(){

            $.ajax({
                url:"calendario/home.php",
                type:"POST",
                data:{
                    sair:'1',
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });

        });


    })
</script>
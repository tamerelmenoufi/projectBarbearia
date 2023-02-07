<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $conf = mysqli_fetch_object(mysqli_query($con, "select * from configuracoes where codigo = '1'"));

    $data_agenda = $_SESSION['agenda_dia'].' '.$_POST['data'];


    $hoje = $abrevSem[date("D")];

    function filtroServicoColaborador($c){
        global $con;
        global $localPainel;
        global $_SESSION;

        $c = implode(", ",$c);

        echo $query = "select
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

            if($grupo != $d->produto_nome){
                echo "<h4>$d->produto_nome</h4>";
            }
        ?>
<div class="card mb-3">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="<?=$localPainel?>src/volume/colaboradores/<?=$d->foto?>" class="img-fluid rounded-start" >
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><?=$d->colaborador_nome?></h5>
        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>
</div>
        <?php
            $grupo = $d->produto_nome;
        }
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

        $("#cliente").selectpicker();
        $("#colaborador").selectpicker();
        $("#servico").selectpicker();


        $("#colaborador").change(function(){
            colaborador = $("#colaborador").val();
            servico = $(this).val();

            $(".cadastrarAgenda").attr("agenda",'');
            $(".cadastrarAgenda span").text('');
            $("span[Titulo]").text('');
            $(".cadastrarAgenda").attr("disabled","disabled");
            $(".horarios").html('');

            if(colaborador && servico){
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
            }
        });


        $('#servico').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            servico = $(this).val();

            $("#colaborador").selectpicker('destroy');
            $(".cadastrarAgenda").attr("agenda",'');
            $(".cadastrarAgenda span").text('');
            $("span[Titulo]").text('');
            $(".cadastrarAgenda").attr("disabled","disabled");
            $(".horarios").html('');

            if(servico){
                $.ajax({
                    url:"calendario/agenda_cadastro.php",
                    type:"POST",
                    data:{
                        servico,
                        acao:'filto_servicos'
                    },
                    success:function(dados){
                        $("#colaborador").html(dados);
                        $("#colaborador").selectpicker('render');

                        // colaborador = $("#colaborador").val();
                        // console.log(`Servicos ${servico}`)
                        // console.log(`colaborador ${colaborador}`)
                        // if(colaborador && servico){
                            $.ajax({
                                type:"POST",
                                data:{
                                    // colaborador,
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

            cliente = $("#cliente").val();
            colaborador = $("#colaborador").val();
            servico = $("#servico").val();
            observacao = $("#observacao").val();
            data_agenda = $(this).attr("agenda");

            // return false;

            if(!cliente || !colaborador || !servico || !data_agenda){
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
                    cliente,
                    colaborador,
                    servico,
                    observacao,
                    data_agenda,
                    acao:'nova_agenda'
                },
                success:function(dados){
                    $.alert('Seu Agendamento foi confirmada!')
                    let myOffCanvas = document.getElementById('offcanvasRight');
                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    openedCanvas.hide();
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
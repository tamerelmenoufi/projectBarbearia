<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $conf = mysqli_fetch_object(mysqli_query($con, "select * from configuracoes where codigo = '1'"));

    $data_agenda = $_SESSION['agenda_dia'].' '.$_POST['data'];


    $hoje = $abrevSem[date("D")];

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
        echo "<option value=''>Selecione</option>";
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
<h4 class="Titulo<?=$md5?>"><d style="color:#918d87">Agenda <span Titulo></span></d></h4>

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
        <label for="colaborador" class="form-label"> <i class="fa fa-people-group"></i> Colaborador (Atendente) <br><small style="color:#a1a1a1; font-size:10px;">Colaboradores desativados estão com agenda indisponível.</small></label>
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
        <label for="servico" class="form-label"> <i class="fa fa-scissors"></i> Serviço</label>
        <select
                name="servico"
                id="servico"
                data-live-search="true"
                data-none-selected-text="Selecione"
                class="selectpicker form-control"
                data-actions-box="true"
                ></select>
    </div>
</div>

<div class="row mb-2">
    <div class="col-12 horarios">
            <b style="color:#fff">Horarios:</b>
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

        $("#servico").change(function(){
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


        $('#colaborador').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            colaborador = $(this).val();

            $("#servico").selectpicker('destroy');
            $(".cadastrarAgenda").attr("agenda",'');
            $(".cadastrarAgenda span").text('');
            $("span[Titulo]").text('');
            $(".cadastrarAgenda").attr("disabled","disabled");
            $(".horarios").html('');

            if(colaborador){
                $.ajax({
                    url:"calendario/agenda_cadastro.php",
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
            }else{
                        $("#servico").html('<option value="">Selecionar</value>');
                        $("#servico").selectpicker('render');
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
                    $.alert('Agenda confirmada!')
                    let myOffCanvas = document.getElementById('offcanvasRight');
                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    openedCanvas.hide();
                }
            });
        });


    })
</script>
<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $s = mysqli_fetch_object(mysqli_query($con, "select * from produtos where codigo = '{$_POST['servico']}'"));

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


    $hj = $abrevSem[date("D", mktime(0,0,0,$mes,$dia,$ano))];
    if($dia_serv->$hj){
        list($hi, $hf) = explode("-",$dia_serv->$hj);
        $inter_ini = strtotime(date("Y-m-d {$hi}:00", mktime(0,0,0,$mes,$dia,$ano)));
        $inter_fim = strtotime(date("Y-m-d {$hf}:00", mktime(0,0,0,$mes,$dia,$ano)));


        $q = "select *, hour(data_agenda) as h, minute(data_agenda) as i from agenda where data_agenda like '%{$ano}-{$mes}-{$dia}%' and colaborador = '{$_POST['colaborador']}' and servico = {$_POST['servico']}";
        $r = mysqli_query($con, $q);
        $ag = [];
        while($h = mysqli_fetch_object($r)){
            $ag[] = "{$h->h}:{$h->i}";
        }

    }

?>
<style>

    .calendario{
        width:100%;
        font-size:12px;
    }
    .calendario td{
        /* width:calc(100/7)%;*/
        height:40px;
        cursor:pointer;
        position:relative;
    }
    .calendario td div{
        position:absolute;
        left:0;
        top:0;
        right:0;
        bottom:0;
        /* opacity:0.5;
        background-color:red; */
    }
    .calendario td div:hover{
        background-color:rgb(138, 154, 91, 0.2);
    }

    .btn-secondary {
    color: #fff;
    background-color: #fa9160;
    border-color: #fa9160;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #e58051;
    border-color: #e58051;
}
.btn-secondary.active, .btn-secondary:active, .show>.btn-secondary.dropdown-toggle {
    color: #fff;
    background-color: #e58051;
    border-color: #e58051;
}
.text-success {
    --bs-text-opacity: 1;
    color: #241f1f!important;
}

.btn-outline-primary {
    color: #393a3c;
    border-color: #515252;
}
.btn-outline-primary:hover {
    color: #fff;
    background-color: #ff8146;
    border-color: #ff8146;

}
.btn-check:active+.btn-outline-primary, .btn-check:checked+.btn-outline-primary, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show, .btn-outline-primary:active {
    color: #fff;
    background-color: #ff8146;
    border-color: #ff8146;
}

.btn-check:active+.btn-outline-primary:focus, .btn-check:checked+.btn-outline-primary:focus, .btn-outline-primary.active:focus, .btn-outline-primary.dropdown-toggle.show:focus, .btn-outline-primary:active:focus {
    box-shadow: 0 0 0 0.25rem rgb(255 129 70);
}
</style>
<div class='card'>
    <table class='table calendario' cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="7" align="center" class="titulo">
            <div class="input-group col">
                <button
                        class="btn btn-secondary busca_data col-3"
                        ano="<?=$ante_a?>"
                        mes="<?=$ante_m?>"
                        dia="<?=$ante_d?>"
                >
                    <i class="fa-solid fa-angle-left"></i>
                </button>
                <select
                    id="opcMes"
                    ano="<?=$ano?>"
                    dia="<?=$dia?>"
                    class="form-control col-3 text-center">
                    <?php
                    foreach($abrevMes as $ind => $val){
                    ?>
                    <option value="<?=$ind?>" <?=(($ind == $mes)?'selected':false)?>><?=$val?></option>
                    <?php
                    }
                    ?>
                </select>
                <input
                    type="text"
                    mes="<?=$mes?>"
                    dia="<?=$dia?>"
                    class="form-control col-3 text-center"
                    id="opcAno"
                    value="<?=$ano?>">
                <button
                        class="btn btn-secondary busca_data col-3"
                        ano="<?=$prox_a?>"
                        mes="<?=$prox_m?>"
                        dia="<?=$prox_d?>"
                >
                    <i class="fa-solid fa-angle-right"></i>
                </button>
            </div>
        </td>
      </tr>
<?php

       for($w=$mes;$w<=$mes;$w++){
		   set_time_limit(90);
			 $w = (($w*1 < 10)?'0'.$w*1:$w);
			 $d1 = mktime(0,0,0, $w, 1, $ano); //verifica o primeiro dia do mes
			 $diaSem = date('w',$d1); //verifica a quantidade de dias da semana para o primeiro dia do mes


?>

			  <tr align='center' class='dias_semana'>
   				<td class='lista_titulo' width="14%">Dom</td>
                <td class='lista_titulo' width="14%">Seg</td>
                <td class='lista_titulo' width="14%">Ter</td>
                <td class='lista_titulo' width="14%">Qua</td>
                <td class='lista_titulo' width="14%">Qui</td>
                <td class='lista_titulo' width="14%">Sex</td>
                <td class='lista_titulo' width="14%">S&aacute;b</td>
              </tr>

			  <tr>

			<!--Coloca os dias em Branco-->
			<?php
                        for ($i = 0; $i < $diaSem; $i++) {
                        echo "<td geral>&nbsp;";
                        }

                    //Enquanto houver dias

                for ($i = 2; $i < 33; $i++) {
					$linha = date('d',$d1);

                    $diaSemana = date("D", mktime(0,0,0, $w, $linha, $ano));

                    //verifica o dia atual

					    if(date(Y) == $ano and date(m) == $w and date(d) == $linha){
                           $hoje = ' (HOJE)';
                        }else{
                           $hoje = false;
                        }


						// list($qtd) = @mysql_fetch_row(@mysql_query("select count(codigo) from t".$_SESSION[sms_usuario_logado]."_".$ano.$w." where data like '%$ano-$w-$linha%'"));

						//echo "select count(codigo) from t".$_SESSION[sms_usuario_logado]."_".$ano.$w." where data like '%$ano-$w-$linha%'";

						echo "<td>";

                        // echo "$linha ".$hoje;
                        if($diaSemana != 'Sun'){
                        echo "<div
                                    class='d-flex align-items-center justify-content-center ".(($qtd)?'text-danger':'agenda text-success')."'
                                    style='".(($linha == $dia)?'background-color:rgb(250 145 96 / 29%)!important':false)."'
                                    ano='$ano'
                                    mes='$w'
                                    dia='$linha'
                                >
                            <p class='".(($hoje)?'text-primary':false)."'>{$linha}
                            <i class='fa-solid fa-circle'></i></p>
                        </div>";
                        }else{
                            echo "{$linha}";
                        }
                        echo "</td>";
					    // Se Sábado desce uma linha
                        if (date('w',$d1) == 6) {
                            echo "<tr>\n";
                        }
                        $d1 = mktime(0,0,0, $w, $i, $ano);
                        if (date('d',$d1) == "01") { break; }
                   }
          ?>
    		</tr>
            <?php
       }
            ?>
	</table>
</div>
<h6 class="mt-2" style="background: #fb8650;color: #fff;padding: 10px;text-align: center;font-size: 22px;border-radius: 7px;"><?="{$dia}/{$mes}/{$ano}"?></h6>

<?php


    // echo "<p>Colab.: {$_POST['colaborador']} - Serv.: {$_POST['servico']}</p>";
if($dia_serv->$hj){
    for($i = $inter_ini; $i <= $inter_fim; $i = (($i + 60*$s->tempo))){

        if(!in_array(date("H:i",$i),$ag)){

        ?>
        <button
            class="btn btn-warning mb-1 mt-1 opcHoras"
            name="opcHoras"
            id="option<?=$i?>"
            autocomplete="off"
            ano="<?=date("Y",$i)?>"
            mes="<?=date("m",$i)?>"
            dia="<?=date("d",$i)?>"
            value="<?=date("H:i",$i)?>"
        >
            <?=date("H:i",$i)?>
        </button>
        <input
            type="checkbox"
            class="btn-check mb-1 mt-1 opcHoras"
            name="opcHoras"
            id="option<?=$i?>"
            autocomplete="off"
            ano="<?=date("Y",$i)?>"
            mes="<?=date("m",$i)?>"
            dia="<?=date("d",$i)?>"
            value="<?=date("H:i",$i)?>"
        >
        <label class="btn btn-outline-primary mb-1 mt-1" for="option<?=$i?>"><?=date("H:i",$i)?></label>
        <!-- <button class="btn btn-primary">
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

<script>

$(function(){

    $("#opcAno").mask("9999")

    mudaClandario = (ano, mes, dia)=>{

        colaborador = '<?=$_POST['colaborador']?>';
        servico = '<?=$_POST['servico']?>';

        $.ajax({
            type:"POST",
            data:{
                colaborador,
                servico,
                ano,
                mes,
                dia
            },
            url:"calendario/horarios.php",
            success:function(dados){
                $(".horarios").html(dados);
                $(".cadastrarAgenda").attr("agenda",'');
                $(".cadastrarAgenda span").text('');
                $("span[Titulo]").text('');
                $(".cadastrarAgenda").attr("disabled","disabled");

            }
        });
    }

    $(".busca_data, .agenda").click(function(){
        ano = $(this).attr("ano");
        mes = $(this).attr("mes");
        dia = $(this).attr("dia");
        mudaClandario(ano, mes, dia);
    });

    $("#opcMes").change(function(){
        ano = $(this).attr("ano");
        mes = $(this).val();
        dia = $(this).attr("dia");
        mudaClandario(ano, mes, dia);
    });

    $("#opcAno").keyup(function(){
        ano = $(this).val();
        mes = $(this).attr("mes");
        dia = $(this).attr("dia");

        if(ano.length == 4){
            mudaClandario(ano, mes, dia);
        }

    });

    $(".opcHoras").click(function(){

        ano = $(this).attr("ano");
        mes = $(this).attr("mes");
        dia = $(this).attr("dia");
        hora = $(this).val();

        agenda = `${ano}-${mes}-${dia} ${hora}`;
        rotulo = `${dia}/${mes}/${ano} ${hora}`;

        $(".cadastrarAgenda").attr("agenda",agenda);
        $(".cadastrarAgenda span").text(rotulo);
        $(".cadastrarAgenda").removeAttr("disabled");
        $("span[Titulo]").text(rotulo);
    });




})

</script>
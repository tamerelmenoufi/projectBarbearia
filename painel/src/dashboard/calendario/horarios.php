<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
    $s = mysqli_fetch_object(mysqli_query($con, "select * from produtos where codigo = '{$_POST['servico']}'"));

    $dia = json_decode($_SESSION['PeriodoLoja']->dias_horas_atendimento);
    $hj = $abrevSem[date("D")];
    list($hi, $hf) = explode("-",$dia->$hj);
    $inter_ini = strtotime(date("Y-m-d {$hi}:00"));
    $inter_fim = strtotime(date("Y-m-d {$hf}:00"));



	if($_GET[OpAno] and $_GET[OpMes]){
		$ano = $_GET[OpAno];
		$mes = $_GET[OpMes];
	}else{
		$ano = date(Y);
		$mes = date(m);
	}

?>
<style>
    .calendario{
        width:100%;
        font-size:12px;
    }
    .calendario td{
        /* width:calc(100/7)%;*/
        height:80px;
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

</style>
<table class='card table calendario' cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="7" align="center" class="titulo">
            <button class="btn btn-secondary">
                <i class="fa-solid fa-angle-left"></i>
            </button>
            <span style="font-size:30px; font-weight:bold; margin-left:10px; margin-right:10px;">Janeiro</span>
            <button class="btn btn-secondary">
                <i class="fa-solid fa-angle-right"></i>
            </button>
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
                        echo "<div class='d-flex align-items-center justify-content-center ".(($qtd)?'text-danger':'agenda text-success')."' data='$ano-$w-$linha'>
                            <p class='".(($hoje)?'text-primary':false)."'>{$linha}<br>
                            <i class='fa-solid fa-circle'></i></p>
                        </div>";

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

<?php


    echo "<p>Colab.: {$_POST['colaborador']} - Serv.: {$_POST['servico']}</p>";

    for($i = $inter_ini; $i <= $inter_fim; $i = (($i + 60*$s->tempo))){
        echo "<p>".date("d/m/Y H:i",$i)." - ".$s->tempo."</p>";
    }

    $inter_ini = strtotime(date("Y-m-d 10:00:00"));
    $inter_fim = strtotime(date("Y-m-d 10:01:00"));
    echo "<p>{$inter_ini} até {$inter_fim}</p>";
    echo ($inter_fim - $inter_ini);
?>
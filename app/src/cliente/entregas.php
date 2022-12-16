<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    function DadosStatus($data, $msg){
        list($d, $h) = explode(" ", $data);
        $h = substr($h, 0, -3);

        return [
            data => $d,
            hora => $h,
            status => $msg
        ];
    }

    function EventoEntrega($data = false, $msg = false){
        $obj = DadosStatus($data, $msg);
        return '<div style="position:relative; width:100%; min-height:90px; padding:10px; clear:both;">

                    <div style="position:absolute; left:-80px; top:10px; font-size:10px; text-align:right;">
                        '.$obj['data'].'<br>
                        '.$obj['hora'].'
                    </div>

                    <div style="position:absolute; height:23px; width:23px; margin:0; padding:0; left:-13px; top:10px; font-size:23px; background-color:#fff; border-radius:100%;">
                        <i class="fa-solid fa-clock" style="position:absolute; margin:0; padding:0; color:green"></i>
                    </div>

                    <div style="position:absolute; left:30px; top:5px; right:5px; border-radius:5px; background-color:#eee; padding:5px;">
                        <div style="position:absolute; left:-7px; top:0px; font-size:25px; color:#eee;">
                            <i class="fa-solid fa-caret-left"></i>
                        </div>
                        '.$obj['status'].'
                    </div>

                </div>';
    }


    $query = "select * from vendas where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    echo "<p>".date("d/m/Y H:i:s")."</p>";

?>

<div style="position:relative; height:auto; margin-left:70px; border-left:solid 3px green; ">
    <?php

        $bordas = false;

        if($d->CANCELED > 0){
            echo EventoEntrega(false, 'Pedido Cancelado');
            $bordas = true;
        }else if($d->COMPLETED > 0){
            echo EventoEntrega($d->COMPLETED,'Entrega Concluída');
            $bordas = true;
        }else{

            if($d->SEARCHING > 0){
                echo EventoEntrega($d->SEARCHING, 'Confirmado Pelo estabelecimento');
                $bordas = true;
            }
            if($d->GOING_TO_ORIGIN > 0){
                echo EventoEntrega($d->GOING_TO_ORIGIN,'Seu pedido está em preparo');
            }
            if($d->ARRIVED_AT_ORIGIN > 0){
                echo EventoEntrega($d->ARRIVED_AT_ORIGIN,'Pedido sendo embalado para entrega');
                $bordas = true;
            }
            if($d->GOING_TO_DESTINATION > 0){
                echo EventoEntrega($d->GOING_TO_DESTINATION,'A entrega está a caminho');
                $bordas = true;
            }
            if($d->ARRIVED_AT_DESTINATION > 0){
                echo EventoEntrega($d->ARRIVED_AT_DESTINATION,'Entrega realizada');
                $bordas = true;
            }
            // if($d->RETURNING > 0){
            //     echo EventoEntrega($d->RETURNING, 'Entregador retornando');
            //     $bordas = true;
            // }

        }

        if($bordas){
    ?>
    <span style="position:absolute; width:15px; height:4px; background-color:green; top:0px; left:-9px;"></span>
    <span style="position:absolute; width:15px; height:4px; background-color:green; bottom:0px; left:-9px;"></span>
    <?php
        }

    ?>

</div>

<script>

    $(function(){
        <?php
        if($d->COMPLETED == 0 and $d->CANCELED == 0){
        ?>
        setTimeout(() => {
            $.ajax({
                url:"src/cliente/entregas.php",
                type:"POST",
                data:{
                    cod:'<?=$_POST['cod']?>'
                },
                success:function(dados){
                    $('p[entrega="<?=$_POST['cod']?>"]').html(dados);
                },
                error:function(){
                    alert('erro');
                }
            });
        }, 10000);
        <?php
        }
        ?>
    })

</script>
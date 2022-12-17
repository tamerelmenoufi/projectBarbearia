<?php
    include("../../includes.php");

    echo "Na aplicação webhook bee da BK";

    file_put_contents("logs/log.txt", print_r($_POST, true));

    if($_POST['webhook']){

        if($_POST['status'] == 'SEARCHING'){
            $limpar = "
                GOING_TO_ORIGIN = '0',
                ARRIVED_AT_ORIGIN = '0',
                GOING_TO_DESTINATION = '0',
                ARRIVED_AT_DESTINATION = '0',
                RETURNING = '0',
                COMPLETED = '0',
                CANCELED = '0',
            ";
        }else if($_POST['status'] == 'COMPLETED'){
            $limpar = "
                situacao = 'c',
            ";
        }else{
            $limpar = false;
        }

        if($_POST['name'] and $_POST['phone']){
            $entregador = " name = '{$_POST['name']}',
                            phone = '{$_POST['phone']}',";
        }


        $q = "update vendas set
                {$limpar}
                {$entregador}
                {$_POST['status']} = '{$_POST['statusDate']}'
            where deliveryId = '{$_POST['deliveryId']}'";
        mysqli_query($con, $q);

        file_put_contents('log_query.txt', $q);

        // {
        //     "deliveryId": "88566", // Bee delivery entrega ID
        //     "externalId": "18238", // empresa integrada pedido ID
        //     "status": "GOING_TO_ORIGIN",
        //     "statusDate": "2019-02-01T03:45:27+00:00", // formato Iso 8601
        //     "desName": "beedelivery",
        //     "worker": {
        //         "name": "RAMON SARMENTO",
        //         "phone": "(84) 123456789"
        //     }
        // }



    }
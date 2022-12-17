<?php

    $Json = '{
            "deliveryId": "88566",
            "externalId": "18238",
            "status": "GOING_TO_ORIGIN",
            "statusDate": "2019-02-01T03:45:27+00:00",
            "desName": "beedelivery",
            "worker": {
                "name": "RAMON SARMENTO",
                "phone": "(84) 123456789"
            }
        }';

    $dados = json_decode($Json);

    print_r($dados);

    echo "<hr>";

    echo "externalId: ".$dados->externalId;



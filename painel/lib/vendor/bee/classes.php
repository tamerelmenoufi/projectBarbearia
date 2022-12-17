<?php


    class Bee {

        public $Ambiente = 'producao'; //homologacao ou producao

        public function ConnectDB(){
            global $con;
            return $con;
        }

        public function Autenticacao(){
            global $cBk;
            return $cBk['bee'][$this->Ambiente]['TOKEN'];
        }
        public function Ambiente($opc){
            if($opc == 'homologacao'){
                return 'api';
            }else{
                return 'api';
            }
        }


        public function ValorViagem($id, $lat, $lng){

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://".$this->Ambiente($this->Ambiente).".beedelivery.com.br/api/v1/public/fees/calculate");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"vehicle\": \"M\",
                \"needReturn\": \"N\",
                \"origin\": {
                    \"externalId\": {$id}
                },
                \"destination\": {
                    \"type\": \"COORDS\",
                    \"address\": {
                        \"latitude\": {$lat},
                        \"longitude\": {$lng}
                    }
                }
            }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: ".$this->Autenticacao()
            ));

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;

        }

        public function NovaEntrega($venda){

            $con = $this->ConnectDB();

            $query = "select v.*,
                             l.id as loja,
                             c.nome as nome_cliente,
                             c.telefone as telefone_cliente,
                             concat(trim(e.rua), ', ',  trim(e.numero), ', ', trim(e.bairro), ', ', trim(e.complemento)) as endereco,
                             e.coordenadas,
                             e.referencia

                    from vendas v
                            left join lojas l on v.loja = l.codigo
                            left join clientes c on v.cliente = c.codigo
                            left join clientes_enderecos e on v.cliente = e.cliente and e.padrao = '1'
                    where v.codigo = '{$venda}'";
            $result = mysqli_query($con, $query);
            $d = mysqli_fetch_object($result);

            $pedido = str_pad($d->codigo, 6, "0", STR_PAD_LEFT);
            list($lat, $lng) = explode(",",$d->coordenadas);

            // var_dump($d);
            // echo "<hr>";
            // echo "{
            //     \"orderExternalId\": {$d->codigo},
            //     \"description\": \"Entrega Pedido #{$pedido}\",
            //     \"needReturn\": \"N\",
            //     \"vehicle\": \"M\",
            //     \"compartmentType\": \"BAG\",
            //     \"completedPermission\": \"S\",
            //     \"needCode\": \"N\",
            //     \"origin\": {
            //         \"externalId\": {$d->loja}
            //     },
            //     \"destination\": {
            //         \"contactName\": \"{$d->nome_cliente}\",
            //         \"contactPhone\": ".str_replace(array('(',')','-',' '), false, trim($d->telefone_cliente)).",
            //         \"type\": \"COORDS\",
            //         \"address\": {
            //             \"latitude\": {$lat},
            //             \"longitude\": {$lng},
            //             \"complement\": \"{$d->referencia}\",
            //             \"streetAddress\": \"{$d->endereco}\"
            //             }
            //         }
            //     }
            // }";

            // exit();

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://".$this->Ambiente($this->Ambiente).".beedelivery.com.br/api/v1/public/deliveries/create");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                \"orderExternalId\": {$d->codigo},
                \"description\": \"Entrega Pedido #{$pedido}\",
                \"needReturn\": \"N\",
                \"vehicle\": \"M\",
                \"compartmentType\": \"BAG\",
                \"completedPermission\": \"S\",
                \"needCode\": \"N\",
                \"origin\": {
                    \"externalId\": \"{$d->loja}\"
                },
                \"destination\": {
                    \"contactName\": \"{$d->nome_cliente}\",
                    \"contactPhone\": ".str_replace(array('(',')','-',' '), false, trim($d->telefone_cliente)).",
                    \"type\": \"COORDS\",
                    \"address\": {
                        \"latitude\": {$lat},
                        \"longitude\": {$lng},
                        \"complement\": \"{$d->referencia}\",
                        \"streetAddress\": \"{$d->endereco}\"
                        }
                    }
                }");

            $Log = "{
                \"orderExternalId\": {$d->codigo},
                \"description\": \"Entrega Pedido #{$pedido}\",
                \"needReturn\": \"N\",
                \"vehicle\": \"M\",
                \"compartmentType\": \"BAG\",
                \"completedPermission\": \"S\",
                \"needCode\": \"N\",
                \"origin\": {
                    \"externalId\": \"{$d->loja}\"
                },
                \"destination\": {
                    \"contactName\": \"{$d->nome_cliente}\",
                    \"contactPhone\": ".str_replace(array('(',')','-',' '), false, trim($d->telefone_cliente)).",
                    \"type\": \"COORDS\",
                    \"address\": {
                        \"latitude\": {$lat},
                        \"longitude\": {$lng},
                        \"complement\": \"{$d->referencia}\",
                        \"streetAddress\": \"{$d->endereco}\"
                        }
                }
            }";

            file_put_contents("log2.txt", $Log);


            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json",
              "Authorization: ".$this->Autenticacao()
            ));

            return $response = curl_exec($ch);
            curl_close($ch);

            // var_dump($response);


        }


    }
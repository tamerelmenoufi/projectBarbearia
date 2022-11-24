<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'coordenadas'){
        $query = "update clientes_enderecos set coordenadas = '{$_POST['coordenadas']}', validacao = '{$_POST['validacao']}' where codigo = '{$_POST['codigo']}'";
        mysqli_query($con, $query);
        exit();
    }


    $query = "select * from clientes_enderecos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $endereco =  "{$d->rua}, {$d->numero}, {$d->bairro}";

    $coordenada = json_decode($d->coordenadas);
    if($coordenada[0] and $coordenada[1]){
        $coordenadas = "{$coordenada[0]},{$coordenada[1]}";
    }else{
        $coordenadas = false;
    }

?>

<style>

    #topo<?=$md5?> {
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
    #map<?=$md5?> {
        position:absolute;
        left:0;
        top:50px;
        bottom:0;
        width:100%;
        z-index:0;
        color:#333;
    }
    .ConfirmaCoordenadas{
        position:fixed;
        bottom:10px;
        z-index: 999;
    }
    .CancelarCoordenadas{
        position:fixed;
        bottom:10px;
        margin-left:200px;
        z-index: 999;
    }
</style>

<h4 class="Titulo<?=$md5?>">Editar Endereço</h4>
    <div id="topo<?=$md5?>">
        <h4><?=$d->nome?></h4>
    </div>
    <div id="map<?=$md5?>"></div>

    <button class="ConfirmaCoordenadas btn btn-success btn-block" coordenada="<?=$d->coordenadas?>">Confirmar a Localização</button>
    <button class="CancelarCoordenadas btn btn-danger btn-block" >Cancelar</button>


    <script>
        Carregando('none');
        //endereco = "Rua Monsenhor Coutinho, 600, Centro, Manaus, Amazonas";
        coordenadas<?=$md5?> = '<?="{$coordenadas}"?>';
        endereco<?=$md5?> = "<?=$endereco?>";
        geocoder<?=$md5?> = new google.maps.Geocoder();
        map<?=$md5?> = new google.maps.Map(document.getElementById("map<?=$md5?>"), {
            zoomControl: false,
            mapTypeControl: false,
            draggable: true,
            scaleControl: false,
            scrollwheel: true,
            navigationControl: false,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            fullscreenControl: false,
            <?php
            if($coordenadas){
            ?>
            center: { lat: <?=$coordenada[0]?>, lng: <?=$coordenada[1]?> },
            zoom: 18,

            <?php
            }
            ?>
        }
        /*{
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        }*/
        );

        marker<?=$md5?> = new google.maps.Marker({
            position: { lat: <?=(($coordenada[0])?:0)?>, lng: <?=(($coordenada[1])?:0)?> },
            map:map<?=$md5?>,
            title: "Hello World!",
            draggable:true,
        });

        google.maps.event.addListener(marker<?=$md5?>, 'dragend', function(marker) {
            var latLng = marker.latLng;
            //alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
            coordenadas = `[${latLng.lat()},${latLng.lng()}]`;
            $.ajax({
                url:"src/clientes/editar_endereco.php",
                type:"POST",
                data:{
                    coordenadas,
                    validacao:'0',
                    codigo:'<?=$d->codigo?>',
                    acao:'coordenadas'
                },
                success:function(dados){

                }
            });
        });


        geocoder<?=$md5?>.geocode({ 'address': endereco<?=$md5?> + ', Manaus, Amazonas, Brasil', 'region': 'BR' }, (results, status) => {

            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0] && !coordenadas<?=$md5?>) {

                    var latitude<?=$md5?> = results[0].geometry.location.lat();
                    var longitude<?=$md5?> = results[0].geometry.location.lng();

                    //$('Endereco').val(results[0].formatted_address);

                    var location<?=$md5?> = new google.maps.LatLng(latitude<?=$md5?>, longitude<?=$md5?>);
                    marker<?=$md5?>.setPosition(location<?=$md5?>);
                    map<?=$md5?>.setCenter(location<?=$md5?>);
                    map<?=$md5?>.setZoom(18);

                    $(".ConfirmaCoordenadas").attr("coordenadas",`[${latitude<?=$md5?>},${longitude<?=$md5?>}]`);
                }
            }
        });

        $(".CancelarCoordenadas").click(function(){
            Carregando();
            $.ajax({
                url:`src/clientes/enderecos.php`,
                type:"POST",
                data:{
                    cliente:'<?=$d->cliente?>'
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                    // let myOffCanvas = document.getElementById('offcanvasDireita');
                    // let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    // openedCanvas.hide();
                }
            });
        })

        $(".ConfirmaCoordenadas").click(function(){
            coordenadas = $(this).attr("coordenadas");
            Carregando();
            $.ajax({
                url:"src/clientes/editar_endereco.php",
                type:"POST",
                data:{
                    coordenadas,
                    validacao:'1',
                    codigo:'<?=$d->codigo?>',
                    acao:'coordenadas'
                },
                success:function(dados){

                    $.ajax({
                        url:`src/clientes/enderecos.php`,
                        type:"POST",
                        data:{
                            opc:'enderecos',
                            cliente:'<?=$d->cliente?>'
                        },
                        success:function(dados){
                            $(".LateralDireita").html(dados);
                            // let myOffCanvas = document.getElementById('offcanvasDireita');
                            // let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                            // openedCanvas.hide();
                        }
                    });

                }
            });

        });

</script>
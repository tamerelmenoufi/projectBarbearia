<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/portal/site/assets/lib/includes.php");

    $query = "select * from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $endereco =  "Av. Djalma Batista, 370 - Chapada";

    $coordenada = json_decode($d->coordenadas);
    if($coordenada[0] and $coordenada[1]){
        $coordenadas = "{$coordenada[0]},{$coordenada[1]}";
    }else{
        $coordenadas = false;
    }


?>

<style>

    #map<?=$md5?> {
        position:relative;
        height: 350px;
        width:100%;
        margin-bottom:30px;
        opacity:0.6;
        z-index:0;
    }
</style>
    <div id="map<?=$md5?>"></div>

    <script>
        // Carregando('none');
        coordenadas<?=$md5?> = '<?="{$coordenadas}"?>';
        endereco<?=$md5?> = "<?=$endereco?>";
        geocoder<?=$md5?> = new google.maps.Geocoder();
        map<?=$md5?> = new google.maps.Map(document.getElementById("map<?=$md5?>"), {
            zoomControl: false,
            mapTypeControl: false,
            draggable: false,
            scaleControl: false,
            scrollwheel: false,
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
            icon:"http://146.190.52.49:8081/app/projectBarbearia/_modelo/assets/img/logo.png",
            draggable:false,
        });

        // google.maps.event.addListener(marker<?=$md5?>, 'dragend', function(marker) {
        //     var latLng = marker.latLng;
        //     alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
        // });


        geocoder<?=$md5?>.geocode({ 'address': endereco<?=$md5?> + ', Manaus, Amazonas, Brasil', 'region': 'BR' }, (results, status) => {

            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0] && !coordenadas<?=$md5?>) {

                    var latitude<?=$md5?> = results[0].geometry.location.lat();
                    var longitude<?=$md5?> = results[0].geometry.location.lng();
                    console.log('Coordenadas:')
                    console.log('Lat:'+latitude<?=$md5?>)
                    console.log('Lng:'+longitude<?=$md5?>)

                    var location<?=$md5?> = new google.maps.LatLng(latitude<?=$md5?>, longitude<?=$md5?>);
                    marker<?=$md5?>.setPosition(location<?=$md5?>);
                    map<?=$md5?>.setCenter(location<?=$md5?>);
                    map<?=$md5?>.setZoom(18);

                }
            }
        });




</script>
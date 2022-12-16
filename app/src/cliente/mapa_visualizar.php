<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $md5 = md5($md5.$_POST['p']);

    $query = "select * from clientes_enderecos where codigo = '{$_POST['e']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $endereco =  "{$d->rua}, {$d->numero}, {$d->bairro}";

    $coordenadas = explode(',', $d->coordenadas);

?>

<style>

    #map<?=$md5?> {
        position:relative;
        height: 100%;
        width:100%;
        opacity:0.6;
        z-index:0;
    }

</style>

    <div id="map<?=$md5?>"></div>

    <script>
        coordenadas<?=$md5?> = '<?=$d->coordenadas?>';
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
            if($d->coordenadas){
            ?>
            center: { lat: <?=$coordenadas[0]?>, lng: <?=$coordenadas[1]?> },
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
            position: { lat: <?=(($coordenadas[0])?:0)?>, lng: <?=(($coordenadas[1])?:0)?> },
            map:map<?=$md5?>,
            title: "Hello World!",
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

                    var location<?=$md5?> = new google.maps.LatLng(latitude<?=$md5?>, longitude<?=$md5?>);
                    marker<?=$md5?>.setPosition(location<?=$md5?>);
                    map<?=$md5?>.setCenter(location<?=$md5?>);
                    map<?=$md5?>.setZoom(18);

                }
            }
        });




</script>
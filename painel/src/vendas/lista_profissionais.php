<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<?php

    $query = "select * from colaboradores where situacao = '1' order by nome asc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

    // for($i=0;$i<10;$i++){
?>
<p><?=$d->nome?></p>
<?php
    }
?>
<script>
    $(function(){
        Carregando('none');

    })
</script>
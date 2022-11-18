<?php
    function AppConnect($db = 'app'){
        $con = mysqli_connect("localhost","root","","project_site");
        mysqli_set_charset( $con, 'utf8');
        return $con;
    }
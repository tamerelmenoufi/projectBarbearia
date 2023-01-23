<?php

    function SendWapp($n, $m){

        $postdata = http_build_query(
            array(
                'numero' => $n, // Receivers phonei
                'mensagem' => $m,
            )
        );
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents('http://wapp.mohatron.com/', false, $context);

    }
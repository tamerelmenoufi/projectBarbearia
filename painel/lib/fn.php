<?php

    function vl($d){
        // $d corresponde a um vetor dos indicies da sessão que se deseja validar
        global $_SESSION;
        global $localPainel;
        $r = false;
        foreach($d as $i => $v){
            if(!$_SESSION[$v]) { echo "<script>window.location.href='{$localPainel}';</script>"; exit(); }
        }
    }


    function dataBr($dt){
        list($d, $h) = explode(" ",$dt);
        list($y,$m,$d) = explode("-",$d);
        $data = false;
        if($y && $m && $d){
            $data = "{$d}/{$m}/$y".(($h)?" {$h}":false);
        }
        return $data;
    }

    function dataMysql($dt){
        list($d, $h) = explode(" ",$dt);
        list($d,$m,$y) = explode("/",$d);
        $data = false;
        if($y && $m && $d){
            $data = "{$y}-{$m}-$d".(($h)?" {$h}":false);
        }
        return $data;
    }

    function montaCheckbox($v){
        $campo = $v['campo'];
        $vetor = $v['vetor'];
        $rotulo = $v['rotulo'];
        $dados = json_decode($v['dados']);
        $exibir = $v['exibir'];
        $destino = $v['campo_destino'];
        // $lista[] = print_r($dados, true);
        $lista[] = '<div class="mb-3"><label for="'.$campo.'"><b>'.$rotulo.'</b></label></div>';
        for($i=0;$i<count($vetor);$i++){
            $lista[] = '  <div class="mb-3 form-check">
            <input
                    type="checkbox"
                    name="'.$campo.'[]"
                    value="'.$vetor[$i].'"
                    class="form-check-input"
                    id="'.$campo.$i.'"
                    '.((@in_array($vetor[$i],$dados))?'checked':false).'
                    '.(($exibir[$vetor[$i]])?' exibir="'.$destino.'" ':' ocultar="'.$destino.'"').'
            >
            <label class="form-check-label" for="'.$campo.$i.'">'.$vetor[$i].'</label>
            </div>';
        }

        if($lista){
            return implode(" ",$lista);
        }
    }

    function montaRadio($v){
        $campo = $v['campo'];
        $vetor = $v['vetor'];
        $rotulo = $v['rotulo'];
        $dados = $v['dados'];
        $exibir = $v['exibir'];
        $destino = $v['campo_destino'];

        $lista[] = '<div class="mb-3"><label for="'.$campo.'"><b>'.$rotulo.'</b></label></div>';
        for($i=0;$i<count($vetor);$i++){
            $lista[] = '  <div class="mb-3 form-check">
            <input
                    type="radio"
                    name="'.$campo.'"
                    value="'.$vetor[$i].'"
                    class="form-check-input"
                    id="'.$campo.$i.'"
                    '.(($vetor[$i] == $dados)?'checked':false).'
                    '.(($exibir[$vetor[$i]])?' exibir="'.$destino.'" ':' ocultar="'.$destino.'"').'
            >
            <label class="form-check-label" for="'.$campo.$i.'">'.$vetor[$i].'</label>
            </div>';
        }
        if($lista){
            return implode(" ",$lista);
        }
    }



    function montaCheckboxFiltro($v){
        $campo = $v['campo'];
        $vetor = $v['vetor'];
        $rotulo = $v['rotulo'];
        $dados = $v['dados'];
        $exibir = $v['exibir'];
        $destino = $v['campo_destino'];
        // $lista[] = print_r($dados, true);
        $lista[] = '<div class="mb-3"><label for="'.$campo.'"><b>'.$rotulo.'</b></label></div>';
        for($i=0;$i<count($vetor);$i++){
            $lista[] = '  <div class="mb-3 form-check">
            <input
                    type="checkbox"
                    name="'.$campo.'[]"
                    value="'.$vetor[$i].'"
                    class="form-check-input"
                    id="'.$campo.$i.'"
                    '.((@in_array($vetor[$i],$dados))?'checked':false).'
                    '.(($exibir[$vetor[$i]])?' exibir="'.$destino.'" ':' ocultar="'.$destino.'"').'
            >
            <label class="form-check-label" for="'.$campo.$i.'">'.$vetor[$i].'</label>
            </div>';
        }

        if($lista){
            return implode(" ",$lista);
        }
    }



    function montaOpcPrint($v){
        $campo = $v['campo'];
        $vetor = $v['vetor'];
        $rotulo = $v['rotulo'];
        $dados = json_decode($v['dados']);
        // $lista[] = print_r($dados, true);
        $lista[] = '<div class="mt-3" style="width:100%; float:none;"><b>'.$rotulo.'</b></div><div style="width:100%; float:none;">';
        for($i=0;$i<count($vetor);$i++){
            $lista[] = '  <span margin-left:15px;">
            <i class="fa-solid fa-square" style="color:#ccc"></i> '.$vetor[$i].'</span>';
        }
        $lista[] = '</div>';
        if($lista){
            return implode(" ",$lista);
        }
    }


    function array_multisum($arr){
        $sum = array_sum($arr);
        foreach($arr as $child) {
            $sum += is_array($child) ? array_multisum($child) : 0;
        }
        return $sum;
    }

    $abrevSem = [
        'Mon' => 'seg',
        'Tue' => 'ter',
        'Wed' => 'qua',
        'Thu' => 'qui',
        'Fri' => 'sex',
        'Sat' => 'sab',
        'Sun' => 'dom'
    ];

    $abrevMes = [
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro',
    ];